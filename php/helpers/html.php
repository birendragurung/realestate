<?php

/**
 * HTML helpers
 */


function table_td($value = '')
{
    return "<td>" . $value . "</td>";
}

function table_tr($value = '')
{
    return "<tr>" . $value . "</tr>";
}

function table_th($value = '')
{
    return "<th>" . $value . "</th>";
}

function html_div($value, $html_attr = null)
{
    if ($html_attr) {
        return "<div  " . $html_attr . " > " . $value . "</div>";
    }
    return "<div>" . $value . "</div>";
}

function parseProperty($data)
{
    $output = "";
    foreach ($data as $key => $project) {
        $output .=
            createAnchor(
                html_div(
                    html_div($project['name'])
                    . html_div($project['description'])
                    . html_div($project['address'])
                    . html_div($project['price'])
                    , "class='data-property-div' style='background-image:url(" . UPLOADS_PATH . $project['img'] . ")'")
                , "singleProperty.php?property-id={$project['id']}");
    }
    return $output;
}

/**
 * @param null $data
 * @param null $href
 * @return string
 *
 */
function createAnchor($data = null, $href = null)
{
    $output = "";
    //	foreach ($data as $key => $item) {
    $output .= "<a href =" . "'" . base_url() . $href . "'" . ">" . $data . "'" . "</a>";
    //	}
    return $output;
}

function parseSingleProperty($data = [])
{
    if (empty($data)) {
        return false;
    }

}

function getTemplate( $data = "")
{
    if ($data == "") {
        return false;
    }
    include_once TEMPLATE_PATH . $data . ".php";
}