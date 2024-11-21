function showCustomToast(message, title = 'Notification', duration = 3000) {
    // Create the toast element
    var toast = document.createElement('div');
    toast.classList.add('demo-static-toast', 'fade', 'show');
    
    // Toast HTML content
    toast.innerHTML = `
        <div aria-atomic="true" aria-live="assertive" class="toast" role="alert">
            <div class="toast-header">
                <h6 class="tx-14 mg-b-0 mg-l-auto px-5">${title}</h6>
                <small class="text-muted px-3">${new Date().toLocaleTimeString()}</small>
                <button aria-label="Close" class="mr-2 mb-1 close tx-normal" data-dismiss="toast" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        </div>
    `;
    const toastDiv = document.querySelector('div.toast-place');
    // Append the toast to the body
    toastDiv.appendChild(toast);

    // Add the close event listener to remove the toast
    toast.querySelector('.close').addEventListener('click', function() {
        toast.classList.add('toast-slide-out'); // Apply slide-out animation
        setTimeout(() => {
            toast.remove(); // Remove from DOM after animation
        }, 530); // Delay to match the animation duration (0.53s)
    });

    // Remove the toast after the specified duration with slide-out effect
    setTimeout(() => {
        toast.classList.add('toast-slide-out'); // Apply slide-out animation
        setTimeout(() => {
            toast.remove(); // Remove from DOM after animation
        }, 530); // Delay to match the animation duration
    }, duration);
}