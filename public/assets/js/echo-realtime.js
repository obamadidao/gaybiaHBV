// Echo Setup v3 - Simplified approach
console.log('🚀 Echo Setup v3 is loading...');

function initializeEcho() {
    console.log('📦 Initializing Echo v3...');
    
    // Get configuration from meta tags
    const config = {
        key: document.querySelector('meta[name="reverb-app-key"]')?.getAttribute('content') || '',
        host: document.querySelector('meta[name="reverb-host"]')?.getAttribute('content') || 'localhost',
        port: document.querySelector('meta[name="reverb-port"]')?.getAttribute('content') || '8080',
        scheme: document.querySelector('meta[name="reverb-scheme"]')?.getAttribute('content') || 'http'
    };
    
    console.log('🔧 Config:', config);
    
    if (!config.key) {
        console.error('❌ REVERB_APP_KEY not found in meta tags');
        return;
    }
    
    // Check libraries
    if (typeof Pusher === 'undefined') {
        console.error('❌ Pusher not available');
        return;
    }
    
    if (typeof Echo === 'undefined') {
        console.error('❌ Echo not available');
        return;
    }
    
    try {
        // Use Pusher broadcaster with Reverb server
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: config.key,
            wsHost: config.host,
            wsPort: parseInt(config.port),
            wssPort: parseInt(config.port),
            forceTLS: config.scheme === 'https',
            encrypted: config.scheme === 'https',
            cluster: 'mt1',
            enabledTransports: ['ws', 'wss'],
            auth: {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'X-Requested-With': 'XMLHttpRequest',
                }
            }
        });
        
        console.log('✅ Echo initialized successfully!', window.Echo);
        console.log('🔍 Echo connector:', window.Echo.connector);
        
        // Setup connection event listeners
        if (window.Echo && window.Echo.connector && window.Echo.connector.pusher) {
            setupConnectionListeners();
        } else {
            console.warn('⚠️ Echo connector not available, retrying in 2 seconds...');
            setTimeout(() => {
                if (window.Echo && window.Echo.connector) {
                    setupConnectionListeners();
                }
            }, 2000);
        }
        
        return true;
        
    } catch (error) {
        console.error('❌ Error initializing Echo:', error);
        return false;
    }
}

function setupConnectionListeners() {
    console.log('🔧 Setting up connection listeners...');
    
    try {
        const pusher = window.Echo.connector.pusher;
        
        pusher.connection.bind('connected', () => {
            console.log('✅ WebSocket connected successfully!');
            console.log('🔍 Connection state:', pusher.connection.state);
        });

        pusher.connection.bind('error', (error) => {
            console.error('❌ WebSocket connection error:', error);
        });

        pusher.connection.bind('disconnected', () => {
            console.warn('⚠️ WebSocket disconnected');
        });
        
        pusher.connection.bind('connecting', () => {
            console.log('🔄 WebSocket connecting...');
        });
        
        pusher.connection.bind('reconnecting', () => {
            console.log('🔄 WebSocket reconnecting...');
        });
        
        console.log('✅ Connection listeners setup complete');
        
    } catch (error) {
        console.error('❌ Error setting up connection listeners:', error);
    }
}

// Test channel subscription
function testChannelSubscription() {
    if (!window.Echo) {
        console.error('❌ Echo not available for testing');
        return false;
    }
    
    console.log('🧪 Testing channel subscription...');
    
    try {
        // Test admin-orders channel
        const testChannel = window.Echo.private('admin-orders')
            .listen('.test-event', (data) => {
                console.log('✅ Test event received:', data);
            })
            .error((error) => {
                console.error('❌ Channel subscription error:', error);
            });
            
        console.log('✅ Channel subscription successful');
        return true;
        
    } catch (error) {
        console.error('❌ Error testing channel subscription:', error);
        return false;
    }
}

// Initialize when ready
let attempts = 0;
const maxAttempts = 15;

function checkAndInit() {
    attempts++;
    
    if (typeof Pusher !== 'undefined' && typeof Echo !== 'undefined') {
        console.log('✅ All libraries loaded, initializing...');
        
        const success = initializeEcho();
        
        if (success) {
            // Test subscription after 3 seconds
            setTimeout(() => {
                testChannelSubscription();
            }, 3000);
        }
        
    } else if (attempts < maxAttempts) {
        console.log(`⏳ Waiting for libraries... (${attempts}/${maxAttempts})`);
        setTimeout(checkAndInit, 500);
    } else {
        console.error('❌ Libraries failed to load after maximum attempts');
    }
}

// Start initialization
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', checkAndInit);
} else {
    checkAndInit();
}

// Global functions
window.checkEchoStatus = function() {
    console.log('📊 Echo Status:', {
        Echo: typeof window.Echo,
        Pusher: typeof Pusher,
        Connector: window.Echo?.connector ? 'available' : 'undefined',
        Connected: window.Echo?.connector?.pusher?.connection?.state || 'unknown'
    });
};

window.testEchoConnection = function() {
    return testChannelSubscription();
};