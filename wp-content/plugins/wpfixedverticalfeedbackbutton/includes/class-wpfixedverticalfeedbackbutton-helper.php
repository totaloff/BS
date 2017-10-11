<?php
class WpfixedverticalfeedbackbuttonHelper {
    /**
     * Ensures that any hex color is properly hashed.
     * Otherwise, returns value untouched.
     *
     * This method should only be necessary if using sanitize_hex_color_no_hash().
     *
     * @since 3.4.0
     *
     * @param string $color
     * @return string
     */
    public static function maybe_hash_hex_color( $color ) {
        if ( $unhashed = WpfixedverticalfeedbackbuttonHelper::sanitize_hex_color_no_hash( $color ) )
            return '#' . $unhashed;

        return $color;
    }

    /**
     * Sanitizes a hex color without a hash. Use sanitize_hex_color() when possible.
     *
     * Saving hex colors without a hash puts the burden of adding the hash on the
     * UI, which makes it difficult to use or upgrade to other color types such as
     * rgba, hsl, rgb, and html color names.
     *
     * Returns either '', a 3 or 6 digit hex color (without a #), or null.
     *
     * @since 3.4.0
     *
     * @param string $color
     * @return string|null
     */
    public static function sanitize_hex_color_no_hash( $color ) {
        $color = ltrim( $color, '#' );

        if ( '' === $color )
            return '';

        return WpfixedverticalfeedbackbuttonHelper::sanitize_hex_color( '#' . $color ) ? $color : null;
    }// end user_can_save

    /**
     * Sanitizes a hex color.
     *
     * Returns either '', a 3 or 6 digit hex color (with #), or nothing.
     * For sanitizing values without a #, see sanitize_hex_color_no_hash().
     *
     * @since 3.4.0
     *
     * @param string $color
     * @return string|void
     */
    public static function sanitize_hex_color( $color ) {
        if ( '' === $color )
            return '';

        // 3 or 6 hex digits, or the empty string.
        if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) )
            return $color;
    }
}