<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation {{ $status }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
        }
        
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
        }
        
        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="40" r="1.5" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="80" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="90" cy="80" r="1" fill="rgba(255,255,255,0.1)"/></svg>');
            opacity: 0.3;
        }
        
        .header-content {
            position: relative;
            z-index: 1;
        }
        
        .logo {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }
        
        .tagline {
            font-size: 16px;
            opacity: 0.9;
            font-weight: 300;
        }
        
        .content {
            padding: 40px 30px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 20px;
        }
        
        .status-confirmed {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        
        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #2c3e50;
        }
        
        .hotel-info {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 8px;
            padding: 25px;
            margin: 25px 0;
            border-left: 4px solid #667eea;
        }
        
        .hotel-name {
            font-size: 22px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 15px;
        }
        
        .date-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 15px;
        }
        
        .date-item {
            background: white;
            padding: 15px;
            border-radius: 6px;
            border: 1px solid #e9ecef;
        }
        
        .date-label {
            font-size: 12px;
            color: #6c757d;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }
        
        .date-value {
            font-size: 16px;
            font-weight: 600;
            color: #2c3e50;
        }
        
        .message {
            font-size: 16px;
            line-height: 1.7;
            margin: 25px 0;
            color: #495057;
        }
        
        .contact-info {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
            text-align: center;
        }
        
        .contact-title {
            font-size: 16px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .contact-email {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            font-size: 16px;
        }
        
        .contact-email:hover {
            text-decoration: underline;
        }
        
        .footer {
            background: #2c3e50;
            color: white;
            padding: 25px 30px;
            text-align: center;
        }
        
        .footer-text {
            font-size: 14px;
            opacity: 0.8;
            margin-bottom: 10px;
        }
        
        .footer-brand {
            font-size: 18px;
            font-weight: 600;
            color: #667eea;
        }
        
        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #e9ecef, transparent);
            margin: 20px 0;
        }
        
        @media (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 8px;
            }
            
            .content {
                padding: 25px 20px;
            }
            
            .header {
                padding: 25px 20px;
            }
            
            .date-info {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .hotel-name {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="header-content">
                <div class="logo">🌍 Tourist</div>
                <div class="tagline">Your Gateway to Amazing Journeys</div>
            </div>
        </div>
        
        <div class="content">
            <div class="status-badge status-confirmed">
                Reservation {{ $status }}
            </div>
            
            <div class="greeting">
                Dear {{ $reservation->user->name }},
            </div>
            
            <div class="message">
                We're delighted to inform you that your reservation has been <strong>{{ $status }}</strong>. Get ready for an unforgettable experience!
            </div>
            
            <div class="hotel-info">
                <div class="hotel-name">
                    🏨 {{ $hotel }}
                </div>
                
                <div class="divider"></div>
                
                <div class="date-info">
                    <div class="date-item">
                        <div class="date-label">Check-in Date</div>
                        <div class="date-value">{{ $checkIn }}</div>
                    </div>
                    <div class="date-item">
                        <div class="date-label">Check-out Date</div>
                        <div class="date-value">{{ $checkOut }}</div>
                    </div>
                </div>
            </div>
            
            <div class="message">
                We can't wait to welcome you and ensure your stay is nothing short of exceptional. Our team is here to make your travel dreams come true!
            </div>
            
            <div class="contact-info">
                <div class="contact-title">Need Assistance?</div>
                <div>
                    We're here to help! Contact us at 
                    <a href="mailto:tourist@gmail.com" class="contact-email">tourist@gmail.com</a>
                </div>
            </div>
        </div>
        
        <div class="footer">
            <div class="footer-text">
                Thank you for choosing us for your travel needs
            </div>
            <div class="footer-brand">
                Tourist Team ✈️
            </div>
        </div>
    </div>
</body>
</html>