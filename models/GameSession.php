<?php
/**
 * Auto generated from Models.proto at 2017-09-23 22:41:53
 */

namespace {
/**
 * GameSession message
 */
class GameSession extends \ProtobufMessage
{
    /* Field index constants */
    const USERID = 1;
    const CREATORID = 2;
    const ROOMID = 3;
    const ROOMTYPE = 4;
    const USERNICKNAME = 5;
    const USERAVATARURL = 6;
    const USERLEVEL = 7;
    const USERRATE = 8;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::USERID => array(
            'name' => 'userId',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::CREATORID => array(
            'name' => 'creatorId',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::ROOMID => array(
            'name' => 'roomId',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::ROOMTYPE => array(
            'name' => 'roomType',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::USERNICKNAME => array(
            'name' => 'userNickName',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::USERAVATARURL => array(
            'name' => 'userAvatarUrl',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::USERLEVEL => array(
            'name' => 'userLevel',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::USERRATE => array(
            'name' => 'userRate',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_FLOAT,
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
        $this->values[self::USERID] = null;
        $this->values[self::CREATORID] = null;
        $this->values[self::ROOMID] = null;
        $this->values[self::ROOMTYPE] = null;
        $this->values[self::USERNICKNAME] = null;
        $this->values[self::USERAVATARURL] = null;
        $this->values[self::USERLEVEL] = null;
        $this->values[self::USERRATE] = null;
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
     * Sets value of 'userId' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setUserId($value)
    {
        return $this->set(self::USERID, $value);
    }

    /**
     * Returns value of 'userId' property
     *
     * @return string
     */
    public function getUserId()
    {
        $value = $this->get(self::USERID);
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
     * Sets value of 'roomType' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setRoomType($value)
    {
        return $this->set(self::ROOMTYPE, $value);
    }

    /**
     * Returns value of 'roomType' property
     *
     * @return integer
     */
    public function getRoomType()
    {
        $value = $this->get(self::ROOMTYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'userNickName' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setUserNickName($value)
    {
        return $this->set(self::USERNICKNAME, $value);
    }

    /**
     * Returns value of 'userNickName' property
     *
     * @return string
     */
    public function getUserNickName()
    {
        $value = $this->get(self::USERNICKNAME);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'userAvatarUrl' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setUserAvatarUrl($value)
    {
        return $this->set(self::USERAVATARURL, $value);
    }

    /**
     * Returns value of 'userAvatarUrl' property
     *
     * @return string
     */
    public function getUserAvatarUrl()
    {
        $value = $this->get(self::USERAVATARURL);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'userLevel' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setUserLevel($value)
    {
        return $this->set(self::USERLEVEL, $value);
    }

    /**
     * Returns value of 'userLevel' property
     *
     * @return integer
     */
    public function getUserLevel()
    {
        $value = $this->get(self::USERLEVEL);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'userRate' property
     *
     * @param double $value Property value
     *
     * @return null
     */
    public function setUserRate($value)
    {
        return $this->set(self::USERRATE, $value);
    }

    /**
     * Returns value of 'userRate' property
     *
     * @return double
     */
    public function getUserRate()
    {
        $value = $this->get(self::USERRATE);
        return $value === null ? (double)$value : $value;
    }
}
}