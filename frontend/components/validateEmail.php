<?php
/**
 * Validates email addresses
 *
 * This class is used to validate email addresses using several different criteria.
 *
 * @version 1.0
 * @author John Morris <support@johnmorrisonline.com>
 */

namespace frontend\components;
class validateEmail
{
    /**
     * Accepted domains
     * @access private
     * @var array
     */
    private $accepted_domains;

    /**
     * The class constructor
     *
     * This sets up the class
     */
    public function __construct()
    {
        // Set the accepted domains property
        $this->accepted_domains = array(
            'fi.uncoma.edu.ar'
        );
    }

    /**
     * Validate email address by domain
     *
     * Checks if the email address belongs to an accepted domain
     */
    public function validate_by_domain($email_address)
    {
        // Get the domain from the email address
        $domain = $this->get_domain(trim($email_address));

        // Check if domain is accepted. Return return if so
        if (in_array($domain, $this->accepted_domains)) {
            return true;
        }

        return false;
    }

    /**
     * Get the domain
     *
     * Gets the domain from an email address
     */
    private function get_domain($email_address)
    {
        // Check if a valid email address was submitted
        if (!$this->is_email($email_address)) {
            return false;
        }

        // Split the email address at the @ symbol
        $email_parts = explode('@', $email_address);

        // Pop off everything after the @ symbol
        $domain = array_pop($email_parts);

        return $domain;
    }

    /**
     * Check email address
     *
     * Checks if the submitted value is a valid email address
     */
    private function is_email($email_address)
    {
        // Filter submitted value to see if it's a proper email address
        if (filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        return false;
    }
}