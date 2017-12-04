<?php 
namespace Login\Annotations;

use Doctrine\Common\Annotations\Annotation;

/** @Annotation */
class Security
{
	/** @var array */
	public $roles;	
}