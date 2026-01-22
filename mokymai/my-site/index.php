<?php
$title = "Style & Elegance Home";
$header = true;
include __DIR__ . '/parts/top.php';
?>

<section class="hero">
    <div class="hero-content">
        <h2 data-top-color>Discover Your Style</h2>
        <p data-top-phrase><?= $phrases ?></p>
        <button data-top-color-button class="btn">Explore Now</button>
    </div>
</section>

<div class="container" id="posts">
    <h2 style="text-align: center; margin-bottom: 2rem;">Latest Posts</h2>
    <div class="posts">
        <article class="post-card">
            <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=400" alt="Fashion Post">
            <div class="post-content">
                <h3>Summer Fashion Trends 2024</h3>
                <p>Discover the hottest summer fashion trends that will make you stand out this season.</p>
                <span class="post-meta">Posted on March 15, 2024</span>
            </div>
        </article>

        <article class="post-card">
            <img src="https://images.unsplash.com/photo-1445205170230-053b83016050?w=400" alt="Fashion Post">
            <div class="post-content">
                <h3>Minimalist Wardrobe Guide</h3>
                <p>Learn how to build a capsule wardrobe that's both stylish and sustainable.</p>
                <span class="post-meta">Posted on March 12, 2024</span>
            </div>
        </article>

        <article class="post-card">
            <img src="https://images.unsplash.com/photo-1487222477894-8943e31ef7b2?w=400" alt="Fashion Post">
            <div class="post-content">
                <h3>Accessorizing Like a Pro</h3>
                <p>Master the art of accessorizing and elevate any outfit with the right pieces.</p>
                <span class="post-meta">Posted on March 10, 2024</span>
            </div>
        </article>
        <article class="post-card">
            <img src="https://images.unsplash.com/photo-1514995669114-7b2f0a0b8a6f?w=400" alt="Street Style">
            <div class="post-content">
                <h3>Street Style Essentials</h3>
                <p>Build a cool, comfortable wardrobe with key streetwear pieces and outfit formulas.</p>
                <span class="post-meta">Posted on March 9, 2024</span>
            </div>
        </article>

        <article class="post-card">
            <img src="https://images.unsplash.com/photo-1520975919561-4f8a3e1d9b6f?w=400" alt="Sustainable Fabrics">
            <div class="post-content">
                <h3>Sustainable Fabrics 101</h3>
                <p>Understand eco-friendly materials and how to choose durable, sustainable garments.</p>
                <span class="post-meta">Posted on March 8, 2024</span>
            </div>
        </article>

        <article class="post-card">
            <img src="https://images.unsplash.com/photo-1503342452485-86f7f9f9c0b1?w=400" alt="Workwear to Weekend">
            <div class="post-content">
                <h3>Workwear to Weekend</h3>
                <p>Transition seamlessly from office looks to casual weekend outfits with simple swaps.</p>
                <span class="post-meta">Posted on March 7, 2024</span>
            </div>
        </article>

        <article class="post-card">
            <img src="https://images.unsplash.com/photo-1519744792095-2f2205e87b6f?w=400" alt="Shoes That Make the Outfit">
            <div class="post-content">
                <h3>Shoes That Make the Outfit</h3>
                <p>Choose the right footwear to elevate any outfit, from sneakers to statement heels.</p>
                <span class="post-meta">Posted on March 6, 2024</span>
            </div>
        </article>

        <article class="post-card">
            <img src="https://images.unsplash.com/photo-1495121605193-b116b5b09a83?w=400" alt="Color Pairing">
            <div class="post-content">
                <h3>Color Pairing Tips</h3>
                <p>Learn practical rules for mixing colors and creating balanced, eye-catching looks.</p>
                <span class="post-meta">Posted on March 5, 2024</span>
            </div>
        </article>

        <article class="post-card">
            <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?w=400" alt="Vintage Finds">
            <div class="post-content">
                <h3>Vintage Finds Guide</h3>
                <p>How to source and style vintage pieces for a unique, timeless wardrobe.</p>
                <span class="post-meta">Posted on March 4, 2024</span>
            </div>
        </article>

        <article class="post-card">
            <img src="https://images.unsplash.com/photo-1541099649105-f69ad21f3246?w=400" alt="Layering Techniques">
            <div class="post-content">
                <h3>Layering Techniques</h3>
                <p>Master layering for depth and texture without adding bulk—seasonal tips included.</p>
                <span class="post-meta">Posted on March 3, 2024</span>
            </div>
        </article>

        <article class="post-card">
            <img src="https://images.unsplash.com/photo-1520975919561-1a6d0e7e3c3b?w=400" alt="Monochrome Outfit">
            <div class="post-content">
                <h3>Monochrome Outfit Ideas</h3>
                <p>Create sleek, cohesive looks using a single color palette with varied tones.</p>
                <span class="post-meta">Posted on March 2, 2024</span>
            </div>
        </article>

        <article class="post-card">
            <img src="https://images.unsplash.com/photo-1520975919561-9f1b6b2f8c8d?w=400" alt="DIY Fashion">
            <div class="post-content">
                <h3>DIY Fashion Hacks</h3>
                <p>Easy customizations and repairs to refresh old clothes and personalize your style.</p>
                <span class="post-meta">Posted on March 1, 2024</span>
            </div>
        </article>

        <article class="post-card">
            <img src="https://images.unsplash.com/photo-1503341455253-b2e723bb3dbb?w=400" alt="Evening Lookbook">
            <div class="post-content">
                <h3>Evening Lookbook 2024</h3>
                <p>Curated evening outfits for every occasion, from cocktail to black-tie events.</p>
                <span class="post-meta">Posted on February 28, 2024</span>
            </div>
        </article>
    </div>
</div>

<?php

include __DIR__ . '/parts/bottom.php';
