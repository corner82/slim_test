<?php

namespace DAL;

interface DalInterface {
    public function getAll();
    public function update($id = null, $params = array());
    public function delete ($id = null);
    public function insert($params = array());
}
