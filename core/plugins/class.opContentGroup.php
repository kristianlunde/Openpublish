<?php
defined('_OP') or die('Access denied');
/**
 *  Copyright (C) 2009 Lars Boldt
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
class opContentGroup {
    protected $elements = array();
    protected $groupLabel = 'Untitled';

    public function __construct($groupLabel) {
        $this->groupLabel = $groupLabel;
    }

    public function addElement($element) {
        if ($element instanceof opContentElement || $element instanceof opContentGroup) {
            $this->elements[] = $element;
        }
    }

    public function getElements() {
        return $this->elements;
    }

    public function getLabel() {
        return $this->groupLabel;
    }
}
?>