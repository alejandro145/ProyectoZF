<?php

namespace Proxies;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class Catalogo_Model_Entity_ProductoProxy extends \Catalogo_Model_Entity_Producto implements \Doctrine\ORM\Proxy\Proxy
{
    private $_entityPersister;
    private $_identifier;
    public $__isInitialized__ = false;
    public function __construct($entityPersister, $identifier)
    {
        $this->_entityPersister = $entityPersister;
        $this->_identifier = $identifier;
    }
    /** @private */
    public function __load()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;

            if (method_exists($this, "__wakeup")) {
                // call this after __isInitialized__to avoid infinite recursion
                // but before loading to emulate what ClassMetadata::newInstance()
                // provides.
                $this->__wakeup();
            }

            if ($this->_entityPersister->load($this->_identifier, $this) === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            unset($this->_entityPersister, $this->_identifier);
        }
    }
    
    
    public function __contstruct()
    {
        $this->__load();
        return parent::__contstruct();
    }

    public function getId()
    {
        $this->__load();
        return parent::getId();
    }

    public function getDescripcion()
    {
        $this->__load();
        return parent::getDescripcion();
    }

    public function setDescripcion($descripcion)
    {
        $this->__load();
        return parent::setDescripcion($descripcion);
    }

    public function getPrecio()
    {
        $this->__load();
        return parent::getPrecio();
    }

    public function setPrecio($precio)
    {
        $this->__load();
        return parent::setPrecio($precio);
    }

    public function getCantidad()
    {
        $this->__load();
        return parent::getCantidad();
    }

    public function setCantidad($cantidad)
    {
        $this->__load();
        return parent::setCantidad($cantidad);
    }

    public function getComentarios()
    {
        $this->__load();
        return parent::getComentarios();
    }

    public function setComentarios($comentarios)
    {
        $this->__load();
        return parent::setComentarios($comentarios);
    }

    public function addComentario(\Catalogo_Model_Entity_Comentario $comentario)
    {
        $this->__load();
        return parent::addComentario($comentario);
    }


    public function __sleep()
    {
        return array('__isInitialized__', 'id', 'descripcion', 'precio', 'cantidad', 'comentarios');
    }

    public function __clone()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;
            $class = $this->_entityPersister->getClassMetadata();
            $original = $this->_entityPersister->load($this->_identifier);
            if ($original === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            foreach ($class->reflFields AS $field => $reflProperty) {
                $reflProperty->setValue($this, $reflProperty->getValue($original));
            }
            unset($this->_entityPersister, $this->_identifier);
        }
        
    }
}