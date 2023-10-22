<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @packge        CodeIgniter
 * @subpackage        Libraries
 * @category        Libraries
 * @author        Ardianta Pargo
 * @license        
 * @link        https://github.com/ardianta/codeigniter-dompdf
 */

use Dompdf\Dompdf;

class Pdf extends Dompdf
{
    /**
     * @var 
     */
    public $filename;
    public function __construct()
    {
        parent::__construct();
        $this->filename = "laporan.pdf";
    }
    /**
     * @access    protected
     * @return    
     */
    protected function ci()
    {
        return get_instance();
    }
    /**
     * @access    public
     * @param    
     * @param    
     * @return   
     */
    public function load_view($view, $data = array())
    {
        $html = $this->ci()->load->view($view, $data, TRUE);
        $this->load_html($html);
        // Render the PDF
        $this->render();
        // Output the generated PDF to Browser
        $this->stream($this->filename, array("Attachment" => false));
    }
}
