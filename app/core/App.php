<?php  

/**
 * App Class - Pangunahing Router at Bootstrap ng Application
 * 
 * Ang class na ito ang nagsisilbing pangunahing router at bootstrap ng application.
 * Ito ang humahawak ng URL parsing, pag-load ng controller, routing ng methods, at pagpasa ng parameters.
 */
class App { 
    
    /**
     * Default na controller na gagamitin kung walang specific na controller sa URL
     * Ito ay papalitan kung may valid na controller na tinukoy sa URL
     */
    protected $controller = 'HomeController';

    /**
     * Default na method/action na tatawagin sa controller
     * Ito ay papalitan kung may valid na method na tinukoy sa URL
     */
    protected $method = 'index';

    /**
     * Array para sa mga URL parameters na ipapasa sa controller method
     * Ito ang mga natitirang segments ng URL pagkatapos ng controller at method
     */
    protected $params = [];

    /**
     * Constructor - Ina-initialize ang application routing
     * 
     * Ang constructor ay:
     * 1. Nagpa-parse ng incoming URL
     * 2. Tinutukoy kung aling controller ang gagamitin
     * 3. Naglo-load ng appropriate na controller file
     * 4. Tinutukoy kung aling method ang tatawagin
     * 5. Kinokolekta ang mga parameters
     * 6. Ipinapatupad ang controller method kasama ang parameters
     */
    public function __construct() {  
        $url = $this->parseUrl();    // I-parse ang URL sa array ng segments

        // I-check kung existing ang requested controller sa controllers directory
        // Kung existing, gamitin ito; kung hindi, gamitin ang default controller
        // Maglagay ng Controller name sa dulo Para mabasa nya like HomeController
        if(file_exists('../app/controllers/' . ucfirst($url[0]) . 'Controller.php')) {
            $this->controller = ucfirst($url[0]) . 'Controller';  // I-set ang controller name mula sa URL
            unset($url[0]);              // Tanggalin ang controller sa URL array para sa parameter processing
        }

        // I-load ang controller file - dapat ito ay existing dahil may default controller tayo
        require_once '../app/controllers/' . $this->controller . '.php';

        // Gumawa ng instance ng controller class
        $this->controller = new $this->controller;

        /**
         * Original URL Method Handler (Naka-comment out)
         * 
         * Ito ang original na logic para sa pag-handle ng URL methods.
         * Ginagamit ito kung ang mga method names mo ay walang hyphen o dash.
         * 
         * Paano ito gumagana:
         * 1. Tinitignan kung may method na tinukoy sa URL (url[1])
         * 2. Tinitignan kung existing ang method name sa controller
         * 3. Kung existing, ginagamit ito; kung hindi, ginagamit ang default method
         * 
         * Halimbawa ng URL na compatible dito:
         * - /admin/dashboard
         * - /admin/appointments
         * - /admin/billing
         * 
         * Hindi compatible ang mga URL na may hyphen tulad ng:
         * - /admin/user-management
         * - /admin/medical-records
         * 
         * Note: Naka-comment out ito para sa reference lang.
         * Kung gusto mong bumalik sa original na routing, i-uncomment mo lang ito
         * at i-comment out ang bagong routing logic sa ibaba.
         * 
        // I-check kung may method na tinukoy sa URL at kung existing ito sa controller
        // Kung valid, gamitin ito; kung hindi, gamitin ang default method
        if(isset($url[1]) AND method_exists($this->controller, $url[1])) {
            $this->method = $url[1];    // I-set ang method name mula sa URL
            unset($url[1]);             // Tanggalin ang method sa URL array para sa parameter processing
        }
         */
        
        /**
         * Modified URL Method Handler
         * 
         * Ito ang bagong logic para sa pag-handle ng URL methods na may hyphen.
         * Ginagawa nitong compatible ang URL na may hyphen (e.g., user-management) 
         * sa PHP method names na camelCase (e.g., userManagement).
         * 
         * Paano ito gumagana:
         * 1. Tinitignan kung may method na tinukoy sa URL (url[1])
         * 2. Kung meron, ginagawang camelCase ang method name gamit ang hyphenToCamelCase
         * 3. Tinitignan kung existing ang converted method name sa controller
         * 4. Kung existing, ginagamit ito; kung hindi, ginagamit ang default method
         * 
         * Halimbawa:
         * URL: /admin/user-management
         * Magiging: userManagement (camelCase) para sa method name
         */
        if(isset($url[1])) {
            $method = $this->hyphenToCamelCase($url[1]);
            if(method_exists($this->controller, $method)) {
                $this->method = $method;
                unset($url[1]);
            }
        }

        // I-set ang parameters array sa mga natitirang URL segments
        // Kung walang natitirang segments, gamitin ang empty array
        $this->params = $url ? array_values($url) : []; 

        // Ipatupad ang controller method kasama ang mga na-collect na parameters
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    /**
     * URL Parser
     * 
     * Nagpa-parse ng URL mula sa GET parameter na 'url' papunta sa array ng segments
     * 
     * @return array Array ng URL segments, o ['home'] kung walang URL na provided
     * 
     * Halimbawa:
     * URL: example.com/index.php?url=users/profile/123
     * Magre-return ng: ['users', 'profile', '123']
     */
    private function parseUrl() {
        if(isset($_GET['url'])) {
            // I-split ang URL sa segments, i-sanitize, at tanggalin ang trailing slashes
            return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }

        return ['home'];  // I-return ang default route kung walang URL na provided
    }

    /**
     * Hyphen to CamelCase Converter
     * 
     * Ang method na ito ang nagko-convert ng hyphenated strings (e.g., user-management)
     * papunta sa camelCase format (e.g., userManagement) na compatible sa PHP method names.
     * 
     * Paano ito gumagana:
     * 1. Pinapalitan ang mga hyphen (-) ng spaces
     * 2. Ginagawang uppercase ang unang letter ng bawat word (ucwords)
     * 3. Tinatanggal ang spaces sa pagitan ng words
     * 4. Ginagawang lowercase ang unang letter ng buong string (lcfirst)
     * 
     * @param string $string Ang string na may hyphen na gusto mong i-convert
     * @return string Ang converted string sa camelCase format
     * 
     * Halimbawa:
     * Input: 'user-management'
     * Output: 'userManagement'
     * 
     * Input: 'medical-records'
     * Output: 'medicalRecords'
     */
    private function hyphenToCamelCase($string) {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('-', ' ', $string))));
    }
}
