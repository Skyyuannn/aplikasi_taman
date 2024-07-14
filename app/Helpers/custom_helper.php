<?php


function selectFlowerType(string $id, $selected = null)
{
    $html = '<select id="' . $id . '" name="' . $id . '" class="form-control jenis-tanaman" width="100%">';
    $html .= '<option value="" selected>Pilih Semua</option>';

    $db = \Config\Database::connect();

    $flowerType = $db->table('t_flowers_type')
        ->select('type')
        ->groupBy('type')
        ->get()
        ->getResult();

    foreach ($flowerType as $type) {
        $isSelected = $selected == $type->type ? 'selected' : '';

        $html .= '<option value="' . $type->type . '" ' . $isSelected . '>' . $type->type . '</option>';
    }

    $html .= '</select>';

    return $html;
}

function blank($value)
{
    if (is_null($value)) {
        return true;
    }

    if (is_string($value)) {
        return trim($value) === '';
    }

    if (is_numeric($value) || is_bool($value)) {
        return false;
    }

    if ($value instanceof Countable) {
        return count($value) === 0;
    }

    return empty($value);
}

function filled($value)
{
    return !blank($value);
}
