<?php
/**
 * \file    C_PersonStatus.php
 * \brief   Defines the different types of users.
 * \details This class associates a constant to each type of users of this application.
*/
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was written for PHP 5');
}

class PersonStatus
{
	// user defined constants
	const STUDENT       = "Etudiant(e)";
	const SPEAKER       = "Intervenant(e)";
	const TEACHER       = "Enseignant(e)";
	const SECRETARY     = "Secrétaire";
	const HEAD          = "Responsable";
	const ADMINISTRATOR = "Administrateur/trice";
	const OTHER         = "Autre";

	/* Integers associated to each status
	0 > OTHER
	1 > STUDENT
	2 > SPEAKER
	3 > TEACHER
	4 > SECRETARY
	5 > HEAD
	6 > ADMINISTRATOR
	*/

	// for DB
	const TABLENAME  = "gstatus";
	const SQLcolumns = "id_person SERIAL REFERENCES gperson(id), status SMALLINT NOT NULL";

	protected $status;

	/**
	 * \brief   PersonStatus’ constructor.
	 * \details The constructor initialize the status with the given parameter.
	 * \param   $newStatus Status given when creating a PersonStatus. Can be a \e string or an \e integer.
	*/
	public function __construct($newStatus)
	{
		if (is_string($newStatus))
		{
			$this->status = $newStatus;
		}
		else if (is_int($newStatus))
		{
			switch ($newStatus)
			{
				case 1:
					$this->status = self::STUDENT;
					break;
				case 2:
					$this->status = self::SPEAKER;
					break;
				case 3:
					$this->status = self::TEACHER;
					break;
				case 4:
					$this->status = self::SECRETARY;
					break;
				case 5:
					$this->status = self::HEAD;
					break;
				case 6:
					$this->status = self::ADMINISTRATOR;
					break;
				default:
					break;
			}
		}
	}

	/**
	 * \brief  Returns the \e string value of the status.
	 * \return The \e string value.
	*/
	public function toString()
	{
		if ($this->status == NULL)
		{
			return "Statut invalide";
		}
		else
		{
			return $this->status;
		}
	}

	/**
	 * \brief  Returns the \e integer value of the status.
	 * \return The \e integer value.
	*/
	public function toInt()
	{
		return self::getIntValue($this->status);
	}

	/**
	 * \brief  Associates to each status an \e integer value.
	 * \param  $aStatus The status from which we want to know the associated \e integer value.
	 * \return The \e integer value of the given status.
	*/
	public static function getIntValue($aStatus)
	{
		switch ($aStatus)
		{
			case (self::STUDENT):
				return 1;
			case (self::SPEAKER):
				return 2;
			case (self::TEACHER):
				return 3;
			case (self::SECRETARY):
				return 4;
			case (self::HEAD):
				return 5;
			case (self::ADMINISTRATOR):
				return 6;
			default:
				return 0;
		}
	}
}
?>
