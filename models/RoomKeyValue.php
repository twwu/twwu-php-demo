<?php
/**
 * Auto generated from RoomKeyValue.proto at 2017-09-23 22:46:25
 */

namespace {
/**
 * RoomKeyValue message
 */
class RoomKeyValue extends \ProtobufMessage
{
    /* Field index constants */
    const ROOMID = 1;
    const CREATORID = 2;
    const AUDIOROOMID = 3;
    const SERVERADDR = 4;
    const SERVERPORT = 5;
    const SERVERKEY = 6;
    const ROOMKEY = 7;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::ROOMID => array(
            'name' => 'roomId',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::CREATORID => array(
            'name' => 'creatorId',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::AUDIOROOMID => array(
            'name' => 'audioRoomId',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::SERVERADDR => array(
            'name' => 'serverAddr',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::SERVERPORT => array(
            'name' => 'serverPort',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SERVERKEY => array(
            'name' => 'serverKey',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::ROOMKEY => array(
            'name' => 'roomKey',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
    );

    /**
     * Constructs new message container and clears its internal state
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * Clears message values and sets default ones
     *
     * @return null
     */
    public function reset()
    {
        $this->values[self::ROOMID] = null;
        $this->values[self::CREATORID] = null;
        $this->values[self::AUDIOROOMID] = null;
        $this->values[self::SERVERADDR] = null;
        $this->values[self::SERVERPORT] = null;
        $this->values[self::SERVERKEY] = null;
        $this->values[self::ROOMKEY] = null;
    }

    /**
     * Returns field descriptors
     *
     * @return array
     */
    public function fields()
    {
        return self::$fields;
    }

    /**
     * Sets value of 'roomId' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setRoomId($value)
    {
        return $this->set(self::ROOMID, $value);
    }

    /**
     * Returns value of 'roomId' property
     *
     * @return string
     */
    public function getRoomId()
    {
        $value = $this->get(self::ROOMID);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'creatorId' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setCreatorId($value)
    {
        return $this->set(self::CREATORID, $value);
    }

    /**
     * Returns value of 'creatorId' property
     *
     * @return string
     */
    public function getCreatorId()
    {
        $value = $this->get(self::CREATORID);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'audioRoomId' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setAudioRoomId($value)
    {
        return $this->set(self::AUDIOROOMID, $value);
    }

    /**
     * Returns value of 'audioRoomId' property
     *
     * @return string
     */
    public function getAudioRoomId()
    {
        $value = $this->get(self::AUDIOROOMID);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'serverAddr' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setServerAddr($value)
    {
        return $this->set(self::SERVERADDR, $value);
    }

    /**
     * Returns value of 'serverAddr' property
     *
     * @return string
     */
    public function getServerAddr()
    {
        $value = $this->get(self::SERVERADDR);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'serverPort' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setServerPort($value)
    {
        return $this->set(self::SERVERPORT, $value);
    }

    /**
     * Returns value of 'serverPort' property
     *
     * @return integer
     */
    public function getServerPort()
    {
        $value = $this->get(self::SERVERPORT);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'serverKey' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setServerKey($value)
    {
        return $this->set(self::SERVERKEY, $value);
    }

    /**
     * Returns value of 'serverKey' property
     *
     * @return string
     */
    public function getServerKey()
    {
        $value = $this->get(self::SERVERKEY);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'roomKey' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setRoomKey($value)
    {
        return $this->set(self::ROOMKEY, $value);
    }

    /**
     * Returns value of 'roomKey' property
     *
     * @return string
     */
    public function getRoomKey()
    {
        $value = $this->get(self::ROOMKEY);
        return $value === null ? (string)$value : $value;
    }
}
}