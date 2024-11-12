

<nav>
    <ul>
    <?php if ($_SESSION == null): ?>
        <li><img src="home-icon.png" alt="Home" class="nav-image"></li>
        <?php else: ?>
        <li><a href="homepage.php"><img src="home-icon.png" alt="Home" class="nav-image"></a></li>
        <?php if ($_SESSION['role'] != 'admin'): ?>
            <li><a href="#">My Books</a></li>
            <?php else: ?>
                <li><a href="admin_dashboard.php">Dash Bord</a></li>
            <?php endif; ?>
       
        <li class="dropdown">
            <a href="#">Browse</a>
            <ul class="dropdown-content">
                <li><a href="#">Adventure Books</a></li>
                <li><a href="#">Romance Books</a></li>
                <li><a href="#">Educational Books</a></li>
            </ul>
        </li>
        <li><a href="#">About</a></li>
        <?php if ($_SESSION['role'] != 'admin'): ?>
            <?php if ($_SESSION['can_add_books']): ?>
                <li><a href="addBook.php">Add Book</a></li>
            <?php else: ?>
                <li><a href="#" class="disabled">Add Book (Requires 3+ months)</a></li>
            <?php endif; ?>
            <?php endif; ?>
        <!-- Check if the user is logged in -->
        <?php if(isset($_SESSION['email'])): ?>
            <li class="user-info">
                <span>Welcome, <?php echo $_SESSION['name']; ?></span> 
                <a href="logout.php" class="logout-btn">Logout</a>
            </li>
        <?php else: ?>
            <li><a href="loginPage.html">Login</a></li>
        <?php endif; ?>
        <?php endif; ?>
    </ul>
</nav>

