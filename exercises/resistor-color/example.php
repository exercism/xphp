<?php

const COLORS = ["black", "brown", "red", "orange", "yellow", "green", "blue", "violet", "grey", "white"];

function colorCode($color)
{
    return array_search($color, COLORS);
}
