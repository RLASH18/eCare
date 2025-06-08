
// // Function to handle click events on side links
// function setActiveLink(event, clickedLink) {
//       // Prevent default link behavior
//       event.preventDefault();

//       // Get all nav links
//       const links = document.querySelectorAll('.side-link');

//       // Remove 'active' class from all
//       links.forEach(link => link.classList.remove('active'));

//       // Add 'active' to clicked one
//       clickedLink.classList.add('active');
// }

// document.querySelectorAll('.side-link[href]').forEach(link => {
//     // Only apply to links that navigate (not #)
//     if (link.getAttribute('href') !== '#') {
//         link.addEventListener('click', function(e) {
//             e.preventDefault();
//             link.classList.add('fade-out');
//             setTimeout(() => {
//                 window.location = link.href;
//             }, 180); // Match the CSS transition duration
//         });
//     }
// });

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


// Get all link elements
    // const links = document.querySelectorAll('.nav-link');

    // links.forEach(link => {
    //   link.addEventListener('click', function(event) {
    //     event.preventDefault(); // Prevent actual link navigation

    //     // Remove 'active' class from all links
    //     links.forEach(l => l.classList.remove('active'));

    //     // Add 'active' class to the clicked link
    //     this.classList.add('active');
    //   });
    // });

