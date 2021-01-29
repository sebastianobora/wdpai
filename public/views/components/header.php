<head>
    <script type="text/javascript" src="/public/js/search.js" defer></script>
    <script type="text/javascript" src="/public/js/dropdown.js" defer></script>
    <link rel="shortcut icon" href="/favicon.ico">
</head>

<header class="header">
    <div class="menu-toggle-hamburger-wrapper">
        <i class="fas fa-bars menu-toggle-hamburger-icon js-menu-toggle"></i>
    </div>

    <div class="search-bar">
        <input class="form-input search-bar-input js-search-bar-input" placeholder="What are you looking for?">
    </div>

    <div class="add-your-type">
        <a class="add-your-type-href" href="/addType">
            <i class="fas fa-plus add-your-type-icon"></i> add your type
        </a>
    </div>

    <div class="avatar-dropdown">

        <a onclick="dropdown()">
            <img src="/public/uploads/<?= $userDetails->getImage(); ?>" alt="Avatar" class="js-avatar-image avatar-image img-fluid">
        </a>

        <div class="avatar-dropdown-content js-avatar-dropdown-content">
            <a class="avatar-dropdown-href" href="/user/<?= $userDetails->getUsername(); ?>">My profile</a>
            <a class="avatar-dropdown-href" href="/userTypes/<?= $userDetails->getUsername(); ?>">My types</a>
            <a class="avatar-dropdown-href" href="/favoriteTypes/<?= $userDetails->getUsername(); ?>">Favorite types</a>
            <a class="avatar-dropdown-href" href="/logout">Logout</a>
        </div>
    </div>
</header>