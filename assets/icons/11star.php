<?php
function wps_star($review) {
    $output = '<div class="wps_star_group">';

    if (is_numeric($review) && $review >= 1 && $review <= 5) {
        $fullNumber = floor($review);

        for ($i = 1; $i <= $fullNumber; $i++) {
            $output .= '<svg xmlns="http://www.w3.org/2000/svg" width="19" height="17" viewBox="0 0 19 17" fill="none">
                <path d="M8.74823 0.591363L6.57214 4.98691L1.70346 5.69405C0.830357 5.82021 0.480451 6.89254 1.11361 7.50672L4.636 10.9262L3.80289 15.7567C3.65293 16.6298 4.57602 17.2838 5.34914 16.8755L9.70464 14.5947L14.0601 16.8755C14.8333 17.2805 15.7563 16.6298 15.6064 15.7567L14.7733 10.9262L18.2957 7.50672C18.9288 6.89254 18.5789 5.82021 17.7058 5.69405L12.8371 4.98691L10.661 0.591363C10.2711 -0.192133 9.14145 -0.202093 8.74823 0.591363Z" fill="#FFC436"/>
            </svg>';
        }

        $decimalNumber = $review - $fullNumber;
        if ($decimalNumber == 0.5) {
            $output .= '<svg xmlns="http://www.w3.org/2000/svg" width="9" height="17" viewBox="0 0 9 17" fill="none">
                <path d="M8.88307 0C8.5045 0 8.12593 0.195925 7.93001 0.591096L5.76155 4.98779L0.909906 5.69179C0.039865 5.81798 -0.308816 6.89059 0.32213 7.50493L3.83218 10.9253L3.00199 15.757C2.85255 16.6238 3.76577 17.2846 4.54283 16.8761L8.88307 14.5981V0Z" fill="#FFC436"/>
            </svg>';
        }
    }
    $output .= '</div>';

    return $output;
}

