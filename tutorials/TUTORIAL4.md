## Modify sidebar links in **_navigation.php_** in admin

1. Modify **_admin/includes/navigation.php_**

- Change index link and cut out dropdown menus in header.
```html
<a class="navbar-brand" href="index.html">CMS Admin</a>
...
... skip ...
...
<!-- cut this below out -->
<li class="dropdown">
    <a href="#" class="dropdown-toggle" ...>
    ... skip ...
```

- And only leave the 'profile','log out', cut out the others.
```html
<!-- cut this below out -->
<li>
    <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
</li>
... skip ...
```

- At the sidebar menu, we only need '6' menus, so delete '3' menus; Charts,Tables,Forms.

- Cut the 'Dropdown' parts, move it to the next of 'Dashboard'.
Then rename its <ul id>, 'data-target' as 'Posts_dropdown'.
Also, rename the menu titles like below.
```html
<li>
    <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown"><i class="fa fa-fw fa-arrows-v"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
    <ul id="posts_dropdown" class="collapse">
        <li>
            <a href="#"> View All Posts </a>
        </li>
        <li>
            <a href="#"> Add Posts </a>
        </li>
    </ul>
</li>
```

- Now, arrange other menus with this order. Make 'Users' also dropdown.
> Dashboard, Posts, Categories, Comments, Users, Profile

