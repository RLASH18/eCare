/**
 * kapag loaded na yung html tsaka lang mag r run yung javascript 
 * pwede gumawa ng function sa baba then call na lang dito 
 */
document.addEventListener('DOMContentLoaded', function () {
    autoDismissAlerts();
});


/**
 * automatic mawawala after 2 secs
 * 
 */
function autoDismissAlerts(timeout = 2000, transition = 300) {
    const alerts = document.querySelectorAll('[role="alert"]');
    alerts.forEach(alert => {
        setTimeout(() => {
            if (alert.parentNode) {
                alert.style.opacity = '0';
                alert.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    alert.remove();
                }, transition);
            }
        }, timeout);
    });
}


/**
 * button doon sa x if manually mo sya ic close 
 * di na need tawagin sa dom
 */
function dismissAlert(button) {
    const alert = button.closest('[role="alert"]');
    alert.style.opacity = '0';
    alert.style.transform = 'translateX(100%)';
    setTimeout(() => {
        alert.remove();
    }, 200);
}

