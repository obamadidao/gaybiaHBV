class CartManager {
    constructor() {
        this.cartCountElement = document.querySelector('.cart-count');
        this.init();
    }

    init() {
        // Load cart count when page loads
        this.loadCartCount();
        
        // Set up periodic refresh (optional - every 30 seconds)
        // setInterval(() => this.loadCartCount(), 30000);
    }

    async loadCartCount() {
        try {
            const response = await fetch('/cart/count', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                const data = await response.json();
                this.updateCartCount(data.count);
            } else {
                console.warn('Failed to load cart count');
            }
        } catch (error) {
            console.error('Error loading cart count:', error);
        }
    }

    updateCartCount(count) {
        if (this.cartCountElement) {
            // Add animation class
            this.cartCountElement.classList.add('updated');
            
            this.cartCountElement.textContent = count;
            
            // Show/hide cart count badge
            if (count > 0) {
                this.cartCountElement.style.display = 'flex';
                this.cartCountElement.setAttribute('data-cart-count', count);
            } else {
                this.cartCountElement.style.display = 'none';
                this.cartCountElement.setAttribute('data-cart-count', '0');
            }
            
            // Remove animation class after animation completes
            setTimeout(() => {
                this.cartCountElement.classList.remove('updated');
            }, 600);
        }

        // Update other cart count elements if they exist
        document.querySelectorAll('[data-cart-count]').forEach(element => {
            if (element !== this.cartCountElement) {
                element.textContent = count;
                element.setAttribute('data-cart-count', count);
                element.style.display = count > 0 ? 'inline' : 'none';
            }
        });

        // Trigger custom event for other scripts to listen
        window.dispatchEvent(new CustomEvent('cartCountUpdated', { 
            detail: { count: count } 
        }));
    }

    // Public method to refresh cart count (can be called from other scripts)
    refresh() {
        this.loadCartCount();
    }
}

// Initialize cart manager when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.cartManager = new CartManager();
});

// Helper function for other scripts to update cart count
window.updateCartCount = function(count) {
    if (window.cartManager) {
        window.cartManager.updateCartCount(count);
    }
};

// Helper function to refresh cart count
window.refreshCartCount = function() {
    if (window.cartManager) {
        window.cartManager.refresh();
    }
};