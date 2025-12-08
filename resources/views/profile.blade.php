@extends('layouts.app')
@section('content')
    <style>
        .profile-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: #1a2332;
            border-radius: 20px;
            color: white;
        }

        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #2d3748;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: #4f46e5;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            font-weight: bold;
            margin-right: 2rem;
        }

        .profile-info h2 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }

        .profile-info p {
            color: #9ca3af;
        }

        .profile-section {
            margin-bottom: 2.5rem;
        }

        .section-title {
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
            color: #4f46e5;
            display: flex;
            align-items: center;
        }

        .section-title svg {
            margin-right: 0.8rem;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .info-item {
            background: #0f1419;
            padding: 1.2rem;
            border-radius: 12px;
        }

        .info-label {
            color: #9ca3af;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .info-value {
            font-size: 1.1rem;
            font-weight: 500;
        }

        .edit-btn {
            background: #4f46e5;
            color: white;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        .edit-btn:hover {
            background: #4338ca;
            transform: translateY(-1px);
        }

        .edit-btn svg {
            margin-right: 0.5rem;
        }

        .security-alert {
            background: #1e1b4b;
            padding: 1rem;
            border-radius: 12px;
            border-left: 4px solid #4f46e5;
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .security-alert svg {
            margin-right: 1rem;
            color: #4f46e5;
        }

        .security-alert p {
            font-size: 0.9rem;
        }

        .security-alert a {
            color: #4f46e5;
            font-weight: 500;
            margin-left: 0.5rem;
        }

        @media (max-width: 768px) {
            .profile-header {
                flex-direction: column;
                text-align: center;
            }

            .profile-avatar {
                margin-right: 0;
                margin-bottom: 1.5rem;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="profile-info">
                <h2>{{ Auth::user()->name }}</h2>
                <p>Member since {{ Auth::user()->created_at->format('M Y') }}</p>
            </div>
        </div>

        <div class="profile-section">
            <h3 class="section-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                Personal Information
            </h3>
            
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Full Name</div>
                    <div class="info-value">{{ Auth::user()->name }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Email Address</div>
                    <div class="info-value">{{ Auth::user()->email }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Phone Number</div>
                    <div class="info-value">{{ Auth::user()->phone ?? 'Not provided' }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Account Type</div>
                    <div class="info-value">{{ Auth::user()->is_premium ? 'Premium' : 'Standard' }}</div>
                </div>
            </div>
            
            <button class="edit-btn" onclick="openEditModal('personal')">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
                Edit Information
            </button>
        </div>

        <div class="profile-section">
            <h3 class="section-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                    <path d="M2 10h20M7 15h1m4 0h1m4 0h1"></path>
                </svg>
                Account Security
            </h3>
            
            <div class="security-alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                <p>Last password change: {{ Auth::user()->password_changed_at ? Auth::user()->password_changed_at->diffForHumans() : 'Never' }}</p>
            </div>
            
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Two-Factor Authentication</div>
                    <div class="info-value">{{ Auth::user()->two_factor_enabled ? 'Enabled' : 'Disabled' }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Last Login</div>
                    <div class="info-value">{{ Auth::user()->last_login_at ? Auth::user()->last_login_at->diffForHumans() : 'Never' }}</div>
                </div>
            </div>
            
            <button class="edit-btn" onclick="openEditModal('security')">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                </svg>
                Security Settings
            </button>
        </div>

        <div class="profile-section">
            <h3 class="section-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="1" x2="12" y2="3"></line>
                    <line x1="12" y1="21" x2="12" y2="23"></line>
                    <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                    <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                    <line x1="1" y1="12" x2="3" y2="12"></line>
                    <line x1="21" y1="12" x2="23" y2="12"></line>
                    <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                    <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                </svg>
                Preferences
            </h3>
            
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Theme</div>
                    <div class="info-value">{{ Auth::user()->theme_preference ?? 'System Default' }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Language</div>
                    <div class="info-value">{{ Auth::user()->language_preference ?? 'English' }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Notification</div>
                    <div class="info-value">{{ Auth::user()->notification_preference ?? 'Email Only' }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Timezone</div>
                    <div class="info-value">{{ Auth::user()->timezone ?? 'UTC' }}</div>
                </div>
            </div>
            
            <button class="edit-btn" onclick="openEditModal('preferences')">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="3"></circle>
                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                </svg>
                Edit Preferences
            </button>
        </div>
    </div>

    <!-- Edit Modal (to be implemented) -->
    <div id="editModal" class="modal" style="display: none;">
        <!-- Modal content would go here -->
    </div>

    <script>
        function openEditModal(type) {
            // In a real implementation, this would open a modal
            // with the appropriate form for editing the selected section
            alert(`Edit ${type} functionality would open here`);
            
            // Example of what you might do:
            // const modal = document.getElementById('editModal');
            // modal.style.display = 'block';
            // Load appropriate form based on type
        }

        // Add any additional JavaScript functionality here
    </script>
@endsection