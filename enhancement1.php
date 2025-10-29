<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enhancement - Root Flower</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
 <?php include("navigation.php"); ?>
    <!-- Main Content -->
    <main>
        <div class="container">
            <section class="enhancement-section">
                <h1>Website Enhancements</h1>
                <p>This page lists the enhancements implemented in this website that go beyond the basic requirements of the assignment.</p>
                
                <div class="enhancement-list">
                    <article class="enhancement-item">
                        <h3>1. CSS Animations & Keyframes - Hero Slideshow</h3>
                        <p><strong>How it goes beyond basic requirements:</strong> Basic assignments typically use static images or simple layouts. This enhancement implements a sophisticated CSS-only slideshow with smooth fade transitions between 5 different background images, creating a dynamic and engaging user experience without JavaScript.</p>
                        
                        <p><strong>Code needed to implement:</strong></p>
                        <div class="code-example">
                            <pre><code>@keyframes fade {
    0%   { opacity: 0; }
    8%   { opacity: 1; }
    20%  { opacity: 1; }
    28%  { opacity: 0; }
    100% { opacity: 0; }
}

.slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    opacity: 0;
    animation: fade 25s infinite;
  }

  .slide1 { background-image: url('photo 1.jpeg'); animation-delay: 0s; }
  .slide2 { background-image: url('photo 2.jpeg'); animation-delay: 5s; }
  .slide3 { background-image: url('photo 3.jpeg'); animation-delay: 10s; }
  .slide4 { background-image: url('photo 4.jpeg'); animation-delay: 15s; }
  .slide5 { background-image: url('photo 5.jpeg'); animation-delay: 20s; }</code></pre>
                        </div>
                      
                        <p><strong>Hyperlink to implementation:</strong> <a href="index.php#hero-section">Hero Section on Main Page</a></p>
                        
                        <p><strong>Third-party source:</strong> CSS animations technique adapted from <a href="https://www.youtube.com/watch?v=oYRda7UtuhA" target="_blank">YouTube Video</a></p>
                        
                    </article>

                    <article class="enhancement-item">
                        <h3>2. CSS Grid Layout System</h3>
                        <p><strong>How it goes beyond basic requirements:</strong> Basic assignments typically use simple block layouts or basic flexbox. This enhancement implements advanced CSS Grid with responsive breakpoints, auto-fit columns, and complex multi-dimensional layouts that automatically adapt to different screen sizes.</p>
                        
                        <p><strong>Code needed to implement:</strong></p>
                        <div class="code-example">
                            <pre><code>.news-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
}
</code></pre>
                        </div>
                       
                        <p><strong>Hyperlink to implementation:</strong> <a href="index.php#news-section">News Section Grid</a></p>
                        
                        <p><strong>Third-party source:</strong> CSS Grid techniques from <a href="https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_Grid_Layout" target="_blank">MDN CSS Grid Layout Documentation</a></p>
                    </article>

                   

                    <article class="enhancement-item">
                        <h3>3. Advanced CSS Transforms & Hover Effects</h3>
                        <p><strong>How it goes beyond basic requirements:</strong> Basic assignments typically use simple hover color changes. This enhancement implements sophisticated 3D-style transforms with translateY, scale effects, and dynamic shadow changes that create depth and modern interaction feedback.</p>
                        
                        <p><strong>Code needed to implement:</strong></p>
                        <div class="code-example">
                            <pre><code>
.news-card {
    background: #FFFBDE;
    border: 1px solid #333;
    border-radius: 12px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
                            
.news-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.news-card:hover .news-image img {
    transform: scale(1.05);
}</code></pre>
                        </div>
                       
                        <p><strong>Hyperlink to implementation:</strong> <a href="index.php#news-cards">News Cards Hover Effects</a></p>
                        
                        <p><strong>Third-party source:</strong> Transform techniques from <a href="https://developer.mozilla.org/en-US/docs/Web/CSS/transform" target="_blank">MDN CSS Transform Documentation</a></p>
                    </article>

                    <article class="enhancement-item">
                        <h3>4. CSS Pseudo-elements for Visual Overlays</h3>
                        <p><strong>How it goes beyond basic requirements:</strong> Basic assignments typically use solid backgrounds or simple styling. This enhancement uses ::before and ::after pseudo-elements to create semi-transparent overlays, enhancing text readability and creating sophisticated visual effects without additional HTML elements.</p>
                        
                        <p><strong>Code needed to implement:</strong></p>
                        <div class="code-example">
                            <pre><code>
.hero::after {
    content: "";
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0, 0, 0, 0.4);
    z-index: 1;
}

.company-intro-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.85);
    z-index: 1;
}
</code></pre>
                        </div>
                   
                        <p><strong>Hyperlink to implementation:</strong> <a href="index.php#hero-section">Hero Section Overlay</a></p>
                        
                        <p><strong>Third-party source:</strong> Pseudo-element techniques from <a href="https://css-tricks.com/almanac/selectors/a/after-and-before/" target="_blank">CSS-Tricks ::before and ::after Guide</a></p>
                    </article>

                    <article class="enhancement-item">
                        <h3>5. Pure CSS Dropdown Navigation System</h3>
                        <p><strong>How it goes beyond basic requirements:</strong> Basic assignments typically use simple navigation lists. This enhancement creates a sophisticated dropdown menu system using only CSS with smooth opacity transitions, proper z-index layering, and hover states that work without JavaScript.</p>
                        
                        <p><strong>Code needed to implement:</strong></p>
                        <div class="code-example">
                            <pre><code>.dropdown { position: relative; }

.dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    background: #ffffff;
    min-width: 200px;
    border: 1px solid #333;
    opacity: 0;
    visibility: hidden;
    z-index: 10;
    list-style: none;
    padding: 0;
    margin: 0;
}

.dropdown:hover .dropdown-menu {opacity: 1; visibility: visible;}
</code></pre>
                        </div>
                     
                        <p><strong>Hyperlink to implementation:</strong> <a href="index.php#navigation">Navigation Dropdown Menus</a></p>
                        
                        <p><strong>Third-party source:</strong> Dropdown technique from <a href="https://css-tricks.com/dropdown-menus-with-more-forgiving-mouse-movement-paths/" target="_blank">CSS-Tricks Dropdown Menus Guide</a></p>
                    </article>

                    <article class="enhancement-item">
                        <h3>6. CSS-Only Responsive Navigation with Progressive Breakpoints</h3>
                        <p><strong>How it goes beyond basic requirements:</strong> Basic assignments typically use simple responsive design or single breakpoints. This enhancement implements a comprehensive responsive navigation system with multiple breakpoints (1200px, 1024px, 900px, 768px), progressive scaling of navigation items, and a CSS-only mobile menu that transforms from horizontal to vertical layout without JavaScript.</p>
                        
                        <p><strong>Code needed to implement:</strong></p>
                        <div class="code-example">
                            <pre><code>/* Progressive responsive breakpoints */
@media (max-width: 1200px) {
    .nav-menu {
        gap: 1.5rem;
    }
    .nav-menu a {
        padding: 0.4rem 0.8rem;
        font-size: 0.95rem;
    }
}

@media (max-width: 1024px) {
    nav {
        padding: 1rem 1.5rem;
    }
    .nav-menu {
        gap: 1.2rem;
    }
    .nav-menu a {
        padding: 0.4rem 0.7rem;
        font-size: 0.9rem;
    }
    .nav-brand h1 {
        font-size: 1.6rem;
    }
    .site-logo {
        height: 42px;
    }
}

@media (max-width: 900px) {
    nav {
        padding: 1rem 1rem;
    }
    .nav-menu {
        gap: 1rem;
    }
    .nav-menu a {
        padding: 0.3rem 0.6rem;
        font-size: 0.85rem;
    }
    .nav-brand h1 {
        font-size: 1.4rem;
    }
    .site-logo {
        height: 38px;
    }
}

@media (max-width: 768px) {
    nav {
        flex-wrap: wrap;
        padding: 1rem;
        min-height: auto;
        position: relative;
    }
    
    /* Show menu indicator */
    nav::after {
        content: "☰ Menu";
        display: block;
        position: absolute;
        top: 1rem;
        right: 1rem;
        color: #FFFBDE;
        font-size: 0.9rem;
        font-weight: 500;
        z-index: 1000;
        padding: 0.5rem;
        background: rgba(0, 0, 0, 0.2);
        border-radius: 4px;
    }
    
    .nav-menu {
        flex-direction: column;
        gap: 0;
        width: 100%;
        margin-top: 1rem;
        background: rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        padding: 0.5rem 0;
        overflow: hidden;
        max-height: 0;
        transition: max-height 0.3s ease;
    }
    
    /* Show menu on hover */
    nav:hover .nav-menu {
        max-height: 1000px;
    }
    
    .nav-menu li {
        width: 100%;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .nav-menu a {
        display: block;
        padding: 1rem 1.5rem;
        width: 100%;
        text-align: left;
        border-radius: 0;
        font-size: 1rem;
    }
}</code></pre>
                        </div>

                        <p><strong>Hyperlink to implementation:</strong> <a href="index.php#navigation">Navigation Menu (resize browser to see responsive behavior)</a></p>
                       
                        <p><strong>Third-party source:</strong> Responsive navigation techniques from <a href="https://web.dev/responsive-web-design-basics/" target="_blank">Google Web Fundamentals - Responsive Web Design</a></p>
                    </article>

                    <article class="enhancement-item">
                        <h3>7. Advanced Responsive Design with Multiple Breakpoints</h3>
                        <p><strong>How it goes beyond basic requirements:</strong> Basic assignments typically use simple responsive design or single breakpoints. This enhancement implements a comprehensive responsive system with multiple breakpoints (991px, 768px, 480px), different grid layouts for each screen size, and mobile-first approach with progressive enhancement for content sections.</p>
                        
                        <p><strong>Code needed to implement:</strong></p>
                        <div class="code-example">
                            <pre><code>@media (max-width: 991px) {
    footer .container {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .news-grid {
        grid-template-columns: 1fr;
    }
    .intro-features {
        flex-direction: column;
    }
    .intro-actions {
        flex-direction: column;
        align-items: center;
    }
}

@media (max-width: 480px) {
    .intro-content h2 {
        font-size: 2rem;
    }
    .news-section h2 {
        font-size: 2rem;
    }
    .hero-content h1 {
        font-size: 2.5rem;
    }
}</code></pre>
                        </div>

                        <p><strong>Hyperlink to implementation:</strong> <a href="index.php#news-section">News Section Grid</a> | <a href="index.php#intro-features">Intro Features Layout</a></p>
                        
                        <p><strong>Third-party source:</strong> Responsive design techniques from <a href="https://web.dev/responsive-web-design-basics/" target="_blank">Google Web Fundamentals - Responsive Web Design</a></p>
                    </article>

                    <article class="enhancement-item">
                        <h3>8. Font Awesome Icons Integration with Security</h3>
                        <p><strong>How it goes beyond basic requirements:</strong> Basic assignments typically use simple text or basic HTML symbols. This enhancement integrates a professional icon library (Font Awesome) via CDN with proper security measures including integrity hashing and CORS policies.</p>
                        
                        <p><strong>Code needed to implement:</strong></p>
                        <div class="code-example">
                            <pre><code>&lt;link rel="stylesheet" 
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" 
      integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" 
      crossorigin="anonymous" 
      referrerpolicy="no-referrer" /&gt;

&lt;!-- Usage example --&gt;
&lt;i class="fa-brands fa-facebook"&gt;&lt;/i&gt;
&lt;i class="fa-solid fa-envelope"&gt;&lt;/i&gt;
&lt;i class="fa-solid fa-phone"&gt;&lt;/i&gt;
&lt;i class="fa-solid fa-map"&gt;&lt;/i&gt;
&lt;i class="fa-solid fa-book"&gt;&lt;/i&gt;
&lt;i class="fa-solid fa-rocket"&gt;&lt;/i&gt;
&lt;i class="fa-regular fa-circle-user"&gt;&lt;/i&gt;
&lt;i class="fa-brands fa-instagram"&gt;&lt;/i&gt;
&lt;i class="fa-brands fa-youtube"&gt;&lt;/i&gt;
&lt;i class="fa-solid fa-sign-in-alt"&gt;&lt;/i&gt;
&lt;i class="fa-solid fa-undo"&gt;&lt;/i&gt;
</code></pre>
                        </div>
                        <p><strong>Hyperlink to implementation:</strong> <a href="index.php#footer"> Icons in Footer</a></p>
                        
                        <p><strong>Third-party source:</strong> <a href="https://fontawesome.com/" target="_blank">Font Awesome Official Website</a> - Free icon library with CDN integration</p>
                        
                        <p><strong>Hyperlink to implementation:</strong> <a href="index.php#footer"> Icons in Footer</a>| <a href="login.php"> Icons in Login Page</a></p>
                    </article>

                    <article class="enhancement-item">
                        <h3>9. Advanced CSS transforms & Hover Effects</h3>
                        <p><strong>How it goes beyond basic requirements:</strong> Basic assignments typically use simple hover color changes. This enhancement implements sophisticated 3D-style transforms with translateY, scale effects, and dynamic shadow changes that create depth and modern interaction feedback.</p>
                        
                        <p><strong>Code needed to implement:</strong></p>
                        <div class="code-example">
                            <pre><code>.box-area{
    display: flex;
    justify-content: flex-start;
    gap:20px;
    flex-wrap:wrap;
    padding-left: 30px;
    padding-top: 10px;
}

.box{
    width:45%;
    border-radius:12px;
}

.box img{
   width:100%;
   border-radius:5px;
   display:block;
   transition: transform 0.8s;
   padding: 15px;
}

.box img:hover{
    transform: scale(1.05);
    box-shadow: 0px 8px 20px rgba(0,0,0,0.4);
}
</code></pre>
                        </div>
                        <p><strong>Hyperlink to implementation:</strong> <a href="workshop.php#box-area">Workshop Images Hover Effects</a></p>
                        
                        <p><strong>Third-party source:</strong> Responsive design techniques from <a href="https://www.youtube.com/watch?v=oYRda7UtuhA" target="_blank">YouTube CSS Animation Tutorial</a></p>
                    </article>

                    <article class="enhancement-item">
                        <h3>10. HTML Tags - Aside</h3>
                        <p><strong>How it goes beyond basic requirements:</strong> The aside tag enhances the webpage by displaying instructor details beside the main content. It goes beyond basic requirements by improving structure, accessibility, and user experience.</p>
                        
                        <p><strong>Code needed to implement:</strong></p>
                        <div class="code-example">
                            <pre><code>.workshop-sidebar{
    position:sticky;
    top:30px;
}

.instructor-card{
    background:white;
    padding:25px;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);  
}

.instructor-card img{
    width:250px;
}
</code></pre>
                        </div>
                        <p><strong>Hyperlink to implementation:</strong> <a href="workshop.php#workshop-sidebar">Workshop Sidebar</a></p>
                        
                        <p><strong>Third-party source:</strong> Responsive design techniques from <a href="https://youtu.be/cTzboA2_a-g?si=5qXo-t1fPmce_itv" target="_blank">HTML Tags - Aside</a></p>
                    </article>

                    <article class="enhancement-item">
                        <h3>11. Advanced CSS transforms & Hover Effects</h3>
                        <p><strong>How it goes beyond basic requirements:</strong> Basic assignments typically use simple hover color changes. This enhancement implements sophisticated 3D-style transforms with translateY, scale effects, and dynamic shadow changes that create depth and modern interaction feedback.</p>
                        
                        <p><strong>Code needed to implement:</strong></p>
                        <div class="code-example">
                            <pre><code>.promo-offers{
    display: flex;
    justify-content: center;
    align-items: stretch;
    gap: 50px;   /*more spacing between cards*/
    flex-wrap: wrap;
    padding: 20px 10px;
    width: 100%;
    margin: 0;  
}

.offer-card{
    flex: 1 1 31%;
    min-width: 280px;
    max-width: 360px;
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.3);
    text-align: center;
    padding: 35px;
    transition: transform 0.3s;
    display: flex;
    flex-direction: column;
    margin-bottom: 20px;
}

.offer-card h3, 
.offer-card p{ 
    margin-bottom: 15px;

}

.offer-card:hover{
    transform: translateY(-5px);
}

.offer-card img{
    width: 100%;
    height: 260px;
    object-fit: cover; /* keeps propotions, crops nicely*/
    border-radius: 10px;
    margin-bottom: 15px;
    
}

.btn{
    margin-top: auto;
    padding: 10px 20px;
    background: #9B7EBD;
    border: none;
    color: #fff;
    border-radius: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.promotion-section{
    margin-bottom: 25px;
}
</code></pre>
                        </div>
                        <p><strong>Hyperlink to implementation:</strong> <a href="promotion.php#promo-offers">Promotion Images Hover Effects</a></p>
                        
                        <p><strong>Third-party source:</strong> Responsive design techniques from <a href="https://www.youtube.com/watch?v=oYRda7UtuhA" target="_blank">YouTube CSS Animation Tutorial</a></p>
                    </article>

                    <article class="enhancement-item">
                        <h3>12. Advanced CSS transforms & Hover Effects</h3>
                        <p><strong>How it goes beyond basic requirements:</strong> Basic assignments typically use simple hover color changes. This enhancement implements sophisticated 3D-style transforms with translateY, scale effects, and dynamic shadow changes that create depth and modern interaction feedback.</p>
                        
                        <p><strong>Code needed to implement:</strong></p>
                        <div class="code-example">
                            <pre><code>.ordered-list{
    max-width: 900px;
    margin:0 auto;
    font-size: 19px;
    line-height: 1.8;
    padding:20px 25px;
    font-weight: 500;
    background: #d6f0d6;
    border-radius: 12px;
    border-left: 6px solid #4CAF50;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
    transition: background 0.4s ease-in-out;
}

.ordered-list:hover{
    background: #dff5df;
}

.ordered-list li{
    margin-left:20px;
    color:#444;
    padding:8px 0;
    font-size: 18px;
    transition: color 0.3s ease;
}

.ordered-list li:hover{
    color:#000000;
}

.promotion-section h2{
    color:#2d5a27;
    margin-bottom: 25px;
    padding-bottom: 12px;
    border-bottom: 2px solid #c8f2c8; 
    text-align: center;
    font-size: 28px;
    font-weight: 600;
    letter-spacing: 1px;
    font-family: 'Segoe UI',sans-serif;
}

.ShopNow{
    text-align: center;
    font-size: 18px;
    margin-bottom: 20px;
}
</code></pre>
                        </div>
                        <p><strong>Hyperlink to implementation:</strong> <a href="promotion.php#promotion-section">Promotion Ordered-lists Hover Effects</a></p>
                        
                        <p><strong>Third-party source:</strong> Responsive design techniques from <a href="https://www.youtube.com/watch?v=oYRda7UtuhA" target="_blank">YouTube CSS Animation Tutorial</a></p>
                    </article>

                    <article class="enhancement-item">
                        <h3>13. Advanced CSS transforms & Hover Effects</h3>
                        <p><strong>How it goes beyond basic requirements:</strong> Basic assignments typically use simple hover color changes. This enhancement implements sophisticated 3D-style transforms with translateY, scale effects, and dynamic shadow changes that create depth and modern interaction feedback.</p>
                        
                        <p><strong>Code needed to implement:</strong></p>
                        <div class="code-example">
                            <pre><code>.profile2-page .table-background {
    background-color: rgba(227, 188, 231, 0.8);
}

.profile2-page .info-table {
    border: 3px solid #658bf1;
}

.profile2-page .info-table th,
.profile2-page .info-table td {
    border: 3px solid #032583;
}

.profile2-page .info-table th {
    background-color: rgba(243, 248, 144, 0.723);
}

.profile2-page .info-table td {
    background-color: rgba(174, 252, 204, 0.573);
    padding-left: 20px;
}

.info-table ul{
    padding-left: 20px;
}

.profile2-page .info-table tr:hover {
    background-color: rgba(202, 244, 125, 0.619);
}

.profile2-page .email-button {
    background-color: rgba(255, 255, 255, 0.69);
}

.profile2-page .email-button:hover {
    background-color: rgba(246, 148, 73, 0.619);
}
</code></pre>
                        </div>
                        <p><strong>Hyperlink to implementation:</strong> <a href="aboutme2.php">About me Page Hover Effects</a></p>
                        
                        <p><strong>Third-party source:</strong> Responsive design techniques from <a href="https://www.youtube.com/watch?v=oYRda7UtuhA" target="_blank">YouTube CSS Animation Tutorial</a></p>
                    </article>

                    <article class="enhancement-item">
                        <h3>14. Advanced CSS transforms & Hover Effects</h3>
                        <p><strong>How it goes beyond basic requirements:</strong> Basic assignments typically use simple hover color changes. This enhancement implements sophisticated 3D-style transforms with translateY, scale effects, and dynamic shadow changes that create depth and modern interaction feedback.</p>
                        
                        <p><strong>Code needed to implement:</strong></p>
                        <div class="code-example">
                            <pre><code>.product-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    padding: 20px;
    max-width: 2000px;
    margin: 0 auto;
}


.product-box {
    background-color: white;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    text-align: center;
    padding: 30px;
    transition: transform 0.3s, box-shadow 0.3s;
}


.product-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
}
</code></pre>
                        </div>
                        <p><strong>Hyperlink to implementation:</strong> <a href="product-selection.php#product-selection">Product Selection Images Hover Effects</a></p>
                        
                        <p><strong>Third-party source:</strong> Responsive design techniques from <a href="https://www.youtube.com/watch?v=oYRda7UtuhA" target="_blank">YouTube CSS Animation Tutorial</a></p>
                    </article>


                </div>
            </section>
        </div>
    </main>

<?php include("footer.php"); ?>