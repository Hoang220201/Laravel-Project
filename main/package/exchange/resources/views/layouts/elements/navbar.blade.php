
<link href="{{ asset('css/navbar.css') }}" rel="stylesheet">



<header>
    <h1 class="logo"><a href="home">CXC</a></h1>
    <nav>
        <ul class="nav__links">
            <li><a href="home">Home</a></li>
            <li><a href="history">BarChart</a></li>
            <li><a href="contact"><button class="contact-button">Contact</button></a></li>
        </ul>
    </nav>
    <div id=hamburger-icon onclick="toggleMobileMenu(this)">
        <div class="bar1"></div>
        <div class="bar2"></div>
        <div class="bar3"></div>
        <ul class="mobile-menu nav__links">
            <li><a href="home">Home</a></li>
            <li><a href="history">BarChart</a></li>
            <li><a href="contact"><button class="contact-button">Contact</button></a></li>
        </ul>
    </div>
   
</header>
