/**
 * Cart Sync với localStorage
 * Xử lý đồng bộ giỏ hàng khi đăng nhập
 */

const CartSync = {
    STORAGE_KEY: "guest_cart_data",

    /**
     * Lấy session cart hiện tại và lưu vào localStorage
     */
    async saveCurrentCartToLocalStorage() {
        try {
            const response = await fetch("/cart/current-session-cart");
            const data = await response.json();

            if (data.success && data.cart_data.length > 0) {
                localStorage.setItem(
                    this.STORAGE_KEY,
                    JSON.stringify(data.cart_data)
                );
                return data.count;
            } else {
                // Xóa localStorage nếu không có cart
                localStorage.removeItem(this.STORAGE_KEY);
                return 0;
            }
        } catch (error) {
            console.error("Lỗi khi lưu cart vào localStorage:", error);
            return 0;
        }
    },

    /**
     * Lấy cart data từ localStorage
     */
    getCartFromLocalStorage() {
        const cartData = localStorage.getItem(this.STORAGE_KEY);
        return cartData ? JSON.parse(cartData) : [];
    },

    /**
     * Xóa cart data từ localStorage
     */
    clearLocalStorageCart() {
        localStorage.removeItem(this.STORAGE_KEY);
    },

    /**
     * Khởi tạo khi trang login load
     */
    async initOnLoginPage() {
        const savedCount = await this.saveCurrentCartToLocalStorage();

        if (savedCount > 0) {
            // Hiển thị thông báo cho user
            const loginForm = document.querySelector(".customer-form");

            if (loginForm) {
                const notice = document.createElement("div");
                notice.className = "alert alert-info mb-3";
                notice.innerHTML = `
                    <i class="icon anm anm-basket-l me-2"></i>
                    Bạn có ${savedCount} sản phẩm trong giỏ hàng. 
                    Đăng nhập để tiếp tục mua sắm!
                `;
                loginForm.insertBefore(notice, loginForm.firstChild);
            }
        }
    },

    /**
     * Xử lý khi submit form login
     */
    handleLoginFormSubmit(form) {
        const cartData = this.getCartFromLocalStorage();

        if (cartData.length > 0) {
            // Thêm cart_data vào form như hidden input
            const hiddenInput = document.createElement("input");
            hiddenInput.type = "hidden";
            hiddenInput.name = "cart_data";
            hiddenInput.value = JSON.stringify(cartData);
            form.appendChild(hiddenInput);
        }
    },

    /**
     * Xóa localStorage sau khi đăng nhập thành công
     */
    clearAfterLoginSuccess() {
        this.clearLocalStorageCart();
        console.log("Đã xóa cart localStorage sau khi đăng nhập thành công");
    },
};

// Auto-run khi DOM loaded
document.addEventListener("DOMContentLoaded", function () {
    // Nếu đang ở trang login client
    if (
        window.location.pathname.includes("login") ||
        document.querySelector(".customer-form")
    ) {
        CartSync.initOnLoginPage();

        // Xử lý form submit - tìm form client login
        const loginForm =
            document.querySelector('form[action*="handle-login"]') ||
            document.querySelector(".customer-form");

        if (loginForm) {
            loginForm.addEventListener("submit", function (e) {
                CartSync.handleLoginFormSubmit(this);
            });
        }
    }

    // Nếu đăng nhập thành công (có success message)
    if (document.querySelector(".alert-success")) {
        CartSync.clearAfterLoginSuccess();
    }
});

// Export để có thể sử dụng từ ngoài
window.CartSync = CartSync;
