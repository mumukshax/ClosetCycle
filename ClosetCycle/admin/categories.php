<?php

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../models/Category.php';

Auth::requireAdmin();

$pageTitle = 'Manage Categories';
$errors = [];
$editCategory = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = filter_input(INPUT_POST, 'action');
    $categoryID = filter_input(INPUT_POST, 'categoryID', FILTER_VALIDATE_INT);
    $categoryName = trim(filter_input(INPUT_POST, 'categoryName') ?? '');

    if ($action === 'add' || $action === 'edit') {
        if ($categoryName === '') {
            $errors[] = 'Category name is required.';
        } elseif (strlen($categoryName) > 60) {
            $errors[] = 'Category name must be 60 characters or less.';
        }

        // Avoid duplicate category names.
        foreach (Category::getAll() as $category) {
            $sameName = strtolower($category['categoryName']) === strtolower($categoryName);
            $differentID = !$categoryID || (int) $category['categoryID'] !== (int) $categoryID;

            if ($sameName && $differentID) {
                $errors[] = 'That category already exists.';
                break;
            }
        }
    }

    if (count($errors) === 0 && $action === 'add') {
        Category::add($categoryName);
        header('Location: ' . BASE_URL . '/admin/categories.php?success=added');
        exit();
    }

    if (count($errors) === 0 && $action === 'edit' && $categoryID) {
        Category::update($categoryID, $categoryName);
        header('Location: ' . BASE_URL . '/admin/categories.php?success=updated');
        exit();
    }

    if ($action === 'delete' && $categoryID) {
        if (!Category::delete($categoryID)) {
            header('Location: ' . BASE_URL . '/admin/categories.php?error=in_use');
            exit();
        }

        header('Location: ' . BASE_URL . '/admin/categories.php?success=deleted');
        exit();
    }

    // Keep the edit form filled in when validation fails.
    if ($action === 'edit' && $categoryID && count($errors) > 0) {
        $editCategory = [
            'categoryID' => $categoryID,
            'categoryName' => $categoryName
        ];
    }
}

$editID = filter_input(INPUT_GET, 'edit', FILTER_VALIDATE_INT);
if ($editID) {
    $editCategory = Category::getById($editID);
}

$categories = Category::getAll();
$success = filter_input(INPUT_GET, 'success');
$error = filter_input(INPUT_GET, 'error');

include __DIR__ . '/../views/admin/categories.php';
