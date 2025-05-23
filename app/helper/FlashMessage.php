<?php

/**
 * FlashMessage Class
 * 
 * Ang class na ito ang responsable sa pagpapakita ng mga temporary messages (flash messages)
 * sa application. Ginagamit ito para ipakita ang mga success, error, at iba pang notifications
 * sa user interface.
 */
class FlashMessage {
    /**
     * set() Method
     * 
     * Ang method na ito ang nagse-save ng flash message sa session.
     * 
     * @param string $name - Ang type ng message (e.g., 'success', 'error')
     * @param string $message - Ang actual na message na ipapakita
     * @param string $class - Optional na CSS class (hindi na ginagamit sa current implementation)
     */
    public static function set($name, $message, $class = '') {
        $_SESSION['flash'][$name] = [
            'message' => $message,
            'class' => $class
        ];
    }

    /**
     * display() Method
     * 
     * Ang method na ito ang responsable sa pagpapakita ng flash message sa UI.
     * Gumagawa ito ng HTML structure na may Tailwind CSS classes para sa styling.
     * 
     * Features:
     * - Responsive design
     * - Color-coded messages (green para sa success, red para sa error)
     * - May icon base sa message type
     * - May dismiss button
     * - Smooth animations
     * 
     * @param string $name - Ang type ng message na ipapakita
     * @return string|null - Ang HTML ng flash message o null kung walang message
     */
    public static function display($name) {
        if(isset($_SESSION['flash'][$name])) {
            $flash = $_SESSION['flash'][$name];
            unset($_SESSION['flash'][$name]);

            // Base classes para sa alert container
            // - fixed: Para sa positioning sa top-right
            // - transform at transition: Para sa smooth animations
            // - z-50: Para nasa taas ng ibang elements
            // - min-w at max-w: Para sa proper sizing
            $baseClasses = 'fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg transform transition-all duration-300 ease-in-out z-50 flex items-center justify-between min-w-[300px] max-w-md';
            
            // Specific classes at icons base sa message type
            // Success: Green theme with checkmark icon
            // Error: Red theme with X icon
            // Others: Blue theme with info icon
            if ($name === 'success') {
                $classes = $baseClasses . ' bg-green-100 border-l-4 border-green-500 text-green-700';
                $icon = '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
            } 
            
            elseif ($name === 'error') {
                $classes = $baseClasses . ' bg-red-100 border-l-4 border-red-500 text-red-700';
                $icon = '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
            } 
            
            else {
                $classes = $baseClasses . ' bg-blue-100 border-l-4 border-blue-500 text-blue-700';
                $icon = '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
            }
            
            // Dismiss button
            // - cursor-pointer: Para maging pointer ang cursor kapag hinover
            // - hover:text-gray-700: Para mag-darken ang icon kapag hinover
            // - focus:outline-none: Para tanggalin ang default focus outline
            $dismissButton = '<button onclick="dismissAlert(this)" class="ml-4 text-gray-500 hover:text-gray-700 focus:outline-none cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>';

            // Final HTML structure
            // - role="alert": Para sa accessibility
            // - flex layout: Para sa proper alignment ng icon at text
            return '<div class="' . $classes . '" role="alert">
                <div class="flex items-center">
                    ' . $icon . '
                    <span>' . htmlspecialchars($flash['message']) . '</span>
                </div>
                ' . $dismissButton . '
            </div>';
        }

        return null;
    }

    /**
     * has() Method
     * 
     * Ang method na ito ang nagche-check kung may existing na flash message
     * para sa specific na type.
     * 
     * @param string $name - Ang type ng message na iche-check
     * @return boolean - True kung may message, False kung wala
     */
    public static function has($name) {
        return isset($_SESSION['flash'][$name]);
    }
}