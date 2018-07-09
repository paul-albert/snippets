<?php

/**
 * Function that converts XML content to CSV format.
 * 
 * @param   string      $text
 * 
 * @return  string
 */
function xmlToCSV ($text) {
    $sx = simplexml_load_string($text); $data = [];
    foreach ($sx as $tour) {
        $row = [
            'Title'     => html_entity_decode($tour->Title),
            'Code'      => $tour->Code,
            'Duration'  => $tour->Duration,
        ];
        $row['Inclusions'] = html_entity_decode(strip_tags($tour->Inclusions));
        $row['Inclusions'] = trim(preg_replace('/\s+/u', ' ', $row['Inclusions']));
        $prices = [];
        foreach ($tour->DEP as $d) {
            $price = ((float) $d['EUR']) * ((isset($d['DISCOUNT'])) ? ((100 - rtrim($d['DISCOUNT'], '%')) / 100) : 1);
            array_push($prices, sprintf('%.2f', $price));
        }
        $row['MinPrice'] = min($prices);
        array_push($data, implode('|', $row));
    }
    
    return implode('|', ['Title', 'Code', 'Duration', 'Inclusions', 'MinPrice']) . PHP_EOL . implode(PHP_EOL, $data);
}

// Usage:
$xml = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'tours.xml');
$csv = xmlToCSV($xml);
file_put_contents(__DIR__ . DIRECTORY_SEPARATOR . 'tours.csv', $csv);
