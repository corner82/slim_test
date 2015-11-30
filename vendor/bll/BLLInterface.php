<?php

namespace BLL;

interface DalInterface {
    public function getAll();
    public function update($id = null);
    public function delete ($id = null);
    public function insert($params = array());
}

