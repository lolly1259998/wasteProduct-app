<div class="social-login-container">
    <div class="divider">
        <span>Or continue with</span>
    </div>
    
    <div class="social-buttons">
        <a href="{{ route('auth.google') }}" class="social-btn google-btn">
            <svg width="20" height="20" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
            </svg>
            Continue with Google
        </a>
        
    </div>
</div>

<style>
    .social-login-container {
        margin-top: 2rem;
    }

    .divider {
        text-align: center;
        margin: 1.5rem 0;
        position: relative;
    }

    .divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: #e0e0e0;
    }

    .divider span {
        background: #fff;
        padding: 0 1rem;
        color: #666;
        font-size: 0.9rem;
        position: relative;
        z-index: 1;
    }

    .social-buttons {
        display: flex;
        flex-direction: column;
        gap: 0.8rem;
    }

    .social-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.8rem;
        padding: 0.9rem 1rem;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .google-btn {
        background: #fff;
        color: #333;
        border-color: #e0e0e0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .google-btn:hover {
        background: #f8f9fa;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }

    .facebook-btn {
        background: #1877F2;
        color: #fff;
    }

    .facebook-btn:hover {
        background: #166fe5;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(24, 119, 242, 0.3);
    }

    .social-btn svg {
        flex-shrink: 0;
    }

    @media (max-width: 480px) {
        .social-buttons {
            gap: 0.6rem;
        }
        
        .social-btn {
            padding: 0.8rem 1rem;
            font-size: 0.9rem;
        }
    }
</style>
