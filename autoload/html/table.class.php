<?php

/**
 * Description of table
 * @author Aivaras Voveris <aivaras@activesec.eu>
 * @since Dec 12, 2011
 */
class html__table
{
    public static function tableHeaders($headers = array())
    {
        $html = '';
        if (!empty($headers)) {
            $html .= '<tr>';
            foreach($headers as $header) {
                $html .= '<th>' . $header . '</th>';
            }
            $html .= '</tr>';
        }
        return $html;
    }

    public static function tableData($data = array())
    {
        $html = '';
        if (!empty($data)) {
            $html .= '<tr>';
            foreach($data as $cell) {
                $html .= '<td valign="top">' . $cell . '</td>';
            }
            $html .= '</tr>';
        }
        return $html;
    }
}
