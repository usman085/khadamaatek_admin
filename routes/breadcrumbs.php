<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push(translateMessage('common.Home'), route('dashboard'));
});

// Home > Groups
Breadcrumbs::for('groups', function ($trail) {
    $trail->parent('home');
    $trail->push(translateMessage('common.Groups'), route('groups.index'));
});

// Home > Groups > add
Breadcrumbs::for('group_add', function ($trail) {
    $trail->parent('groups');
    $trail->push(translateMessage('common.AddGroup'), route('groups.create'));
});

// Home > Groups > Edit
Breadcrumbs::for('group_edit', function ($trail) {
    $trail->parent('groups');
    $trail->push(translateMessage('common.EditGroup'), route('groups.create'));
});

// Home > Department
Breadcrumbs::for('departments', function ($trail) {
    $trail->parent('home');
    $trail->push(translateMessage('common.Departments'), route('department.index'));
});

// Home > Department > add
Breadcrumbs::for('department_add', function ($trail) {
    $trail->parent('departments');
    $trail->push(translateMessage('common.AddDepartment'), route('department.create'));
});

// Home > Department > Edit
Breadcrumbs::for('department_edit', function ($trail) {
    $trail->parent('departments');
    $trail->push(translateMessage('common.EditDepartment'), route('department.create'));
});

// Home > Category
Breadcrumbs::for('categories', function ($trail) {
    $trail->parent('home');
    $trail->push(translateMessage('common.Categories'), route('category.index'));
});

// Home > Category > add
Breadcrumbs::for('category_add', function ($trail) {
    $trail->parent('categories');
    $trail->push(translateMessage('common.AddCategory'), route('category.create'));
});

// Home > Category > Edit
Breadcrumbs::for('category_edit', function ($trail) {
    $trail->parent('categories');
    $trail->push(translateMessage('common.EditCategory'), route('category.create'));
});

// Home > Category > Edit
Breadcrumbs::for('category_child', function ($trail) {
    $trail->parent('categories');
    $trail->push(translateMessage('common.ViewChildCategories'), route('category.create'));
});

// Home > Service
Breadcrumbs::for('services', function ($trail) {
    $trail->parent('home');
    $trail->push(translateMessage('common.Services'), route('service.index'));
});

// Home > Service > add
Breadcrumbs::for('service_add', function ($trail) {
    $trail->parent('services');
    $trail->push(translateMessage('common.AddService'), route('service.create'));
});

// Home > Service > Edit
Breadcrumbs::for('service_edit', function ($trail) {
    $trail->parent('services');
    $trail->push(translateMessage('common.EditService'), route('service.create'));
});


// Home > Order
Breadcrumbs::for('orders', function ($trail) {
    $trail->parent('home');
    $trail->push(translateMessage('common.Orders'), route('order.index'));
});
// Home > Order
Breadcrumbs::for('sales', function ($trail) {
    $trail->parent('home');
    $trail->push(translateMessage('common.Sales'), route('report.index'));
});


// Home > Order > add
Breadcrumbs::for('order_add', function ($trail) {
    $trail->parent('orders');
    $trail->push(translateMessage('common.AddOrder'), route('order.index'));
});

// Home > Order > Edit
Breadcrumbs::for('order_edit', function ($trail) {
    $trail->parent('orders');
    $trail->push(translateMessage('common.EditOrder'), route('order.index'));
});

// Home > Transactions
Breadcrumbs::for('transactions', function ($trail) {
    $trail->parent('home');
    $trail->push(translateMessage('common.Transactions'), route('transaction.index'));
});
// Home > Order > Edit
Breadcrumbs::for('transaction_edit', function ($trail) {
    $trail->parent('transactions');
    $trail->push(translateMessage('common.EditTransaction'), route('transaction.index'));
});

// Home > Customer
Breadcrumbs::for('customers', function ($trail) {
    $trail->parent('home');
    $trail->push(translateMessage('common.Customers'), route('customers.index'));
});

// Home > Customer > add
Breadcrumbs::for('customer_add', function ($trail) {
    $trail->parent('customers');
    $trail->push(translateMessage('common.AddCustomer'), route('customers.create'));
});

// Home > Customer > Edit
Breadcrumbs::for('customer_edit', function ($trail) {
    $trail->parent('customers');
    $trail->push(translateMessage('common.EditCustomer'), route('customers.create'));
});

// Home > Template
Breadcrumbs::for('templates', function ($trail) {
    $trail->parent('home');
    $trail->push(translateMessage('common.RequirementTemplates'), route('forms.index'));
});

// Home > Template > add
Breadcrumbs::for('template_add', function ($trail) {
    $trail->parent('templates');
    $trail->push(translateMessage('common.AddRequirementTemplate'), route('forms.create'));
});

// Home > Template > Edit
Breadcrumbs::for('template_edit', function ($trail) {
    $trail->parent('templates');
    $trail->push(translateMessage('common.EditRequirementTemplate'), route('forms.create'));
});

// Home > Template > Edit
Breadcrumbs::for('template_show', function ($trail) {
    $trail->parent('templates');
    $trail->push(translateMessage('common.ViewRequirementTemplate'), route('forms.create'));
});

// Home > Documents
Breadcrumbs::for('documents', function ($trail) {
    $trail->parent('home');
    $trail->push(translateMessage('common.DocumentTemplates'), route('documents.index'));
});

// Home > Documents > add
Breadcrumbs::for('document_add', function ($trail) {
    $trail->parent('documents');
    $trail->push(translateMessage('common.AddDocumentTemplate'), route('documents.create'));
});

// Home > Documents > Edit
Breadcrumbs::for('document_edit', function ($trail) {
    $trail->parent('documents');
    $trail->push(translateMessage('common.EditDocumentTemplate'), route('documents.create'));
});

// Home > Documents > Edit
Breadcrumbs::for('document_show', function ($trail) {
    $trail->parent('documents');
    $trail->push(translateMessage('common.ViewDocumentTemplate'), route('documents.create'));
});


// Home > User
Breadcrumbs::for('users', function ($trail) {
    $trail->parent('home');
    $trail->push(translateMessage('common.Users'), route('users.index'));
});

// Home > User > add
Breadcrumbs::for('user_add', function ($trail) {
    $trail->parent('users');
    $trail->push(translateMessage('common.AddUser'), route('users.create'));
});

// Home > User > Edit
Breadcrumbs::for('user_edit', function ($trail) {
    $trail->parent('users');
    $trail->push(translateMessage('common.EditUser'), route('users.create'));
});

// Home > Roles
Breadcrumbs::for('roles', function ($trail) {
    $trail->parent('home');
    $trail->push(translateMessage('common.Roles'), route('roles.index'));
});

// Home > Roles > add
Breadcrumbs::for('role_add', function ($trail) {
    $trail->parent('roles');
    $trail->push(translateMessage('common.AddRole'), route('roles.create'));
});

// Home > Roles > Edit
Breadcrumbs::for('role_edit', function ($trail) {
    $trail->parent('roles');
    $trail->push(translateMessage('common.EditRole'), route('roles.create'));
});

// Home > Roles
Breadcrumbs::for('permissions', function ($trail) {
    $trail->parent('home');
    $trail->push(translateMessage('common.RolePermissions'), route('menu.index'));
});

// Home > Roles > Edit
Breadcrumbs::for('permission_edit', function ($trail) {
    $trail->parent('permissions');
    $trail->push(translateMessage('common.UpdateRolePermission'), route('roles.create'));
});

// Home > Profile
Breadcrumbs::for('profile', function ($trail) {
    $trail->parent('home');
    $trail->push(translateMessage('common.profile'), route('user.profile'));
});


// Home > Blog > [Category] > [Post]
// Breadcrumbs::for('post', function ($trail, $post) {
//     $trail->parent('category', $post->category);
//     $trail->push($post->title, route('post', $post->id));
// });
