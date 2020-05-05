<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bc_places_view".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $city_id
 * @property int $country_id
 * @property int $district_id
 * @property string $address
 * @property string $lat
 * @property string $lng
 * @property string $street
 * @property string $street_ua
 * @property string $street_en
 * @property string $lat_str
 * @property string $lng_str
 * @property int $sort_order
 * @property int $class_id
 * @property int $percent_commission
 * @property int $active
 * @property string $contacts_admin
 * @property int $hide
 * @property string $redirect
 * @property int $hide_contacts
 * @property string $email
 * @property string $email_name
 * @property int $approved
 * @property string $total_m2
 * @property string $name
 * @property string $name_ua
 * @property string $name_en
 * @property string $content
 * @property string $content_ua
 * @property string $content_en
 * @property string $title
 * @property string $title_ua
 * @property string $title_en
 * @property string $keywords
 * @property string $keywords_ua
 * @property string $keywords_en
 * @property string $description
 * @property string $description_ua
 * @property string $description_en
 * @property string $annons
 * @property string $annons_ua
 * @property string $annons_en
 * @property string $mgr_content
 * @property string $mgr_content_ua
 * @property string $mgr_content_en
 * @property string $shuttle
 * @property string $shuttle_ua
 * @property string $shuttle_en
 * @property string $contacts
 * @property string $contacts_ua
 * @property string $contacts_en
 * @property string $on_foot
 * @property string $on_foot_ua
 * @property string $on_foot_en
 * @property string $by_car
 * @property string $by_car_ua
 * @property string $by_car_en
 * @property int $pid
 * @property string $pcreated_at
 * @property string $pupdated_at
 * @property int $item_id
 * @property int $m2
 * @property int $m2min
 * @property int $valute_id
 * @property string $stage_name
 * @property int $price_period
 * @property int $ai
 * @property int $commission
 * @property string $opex
 * @property int $plan_comment
 * @property int $phide
 * @property int $archive
 * @property int $price
 * @property int $con_price
 * @property string $tax
 * @property string $kop
 * @property string $phone
 * @property string $pemail
 * @property int $status_id
 * @property int $rent
 * @property int $hits
 * @property int $phide_contacts
 * @property string $comment
 * @property string $fio
 * @property string $comment_ua
 * @property string $fio_ua
 * @property string $comment_en
 * @property string $fio_en
 * @property string $pname
 * @property string $pname_ua
 * @property string $pname_en
 * @property string $ptitle
 * @property string $ptitle_ua
 * @property string $ptitle_en
 * @property string $pkeywords
 * @property string $pkeywords_ua
 * @property string $pkeywords_en
 * @property string $pdescription
 * @property string $pdescription_ua
 * @property string $pdescription_en
 * @property int $hide_bc
 * @property int $no_bc
 * @property double $uah_price
 * @property double $usd_price
 * @property double $eur_price
 * @property double $rub_price
 */
class BcPlacesView extends \yii\db\ActiveRecord
{
    public $minPrice;
    public $maxPrice;
    public $minM2;
    public $maxM2;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bc_places_view';
    }

    /**
     * {@inheritdoc}
     */
    /*public function rules()
    {
        return [
            [['id', 'city_id', 'country_id', 'district_id', 'sort_order', 'class_id', 'percent_commission', 'active', 'hide', 'hide_contacts', 'approved', 'pid', 'item_id', 'm2', 'm2min', 'valute_id', 'price_period', 'ai', 'commission', 'plan_comment', 'phide', 'archive', 'price', 'con_price', 'status_id', 'rent', 'hits', 'phide_contacts', 'hide_bc', 'no_bc'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at', 'pcreated_at', 'pupdated_at'], 'safe'],
            [['country_id', 'address', 'lat', 'lng', 'sort_order', 'class_id', 'active', 'hide', 'item_id', 'm2', 'valute_id', 'price_period', 'ai', 'phide', 'archive', 'con_price'], 'required'],
            [['lat', 'lng', 'lat_str', 'lng_str', 'total_m2', 'opex', 'tax', 'kop', 'uah_price', 'usd_price', 'eur_price', 'rub_price'], 'number'],
            [['contacts_admin', 'content', 'content_ua', 'content_en', 'annons', 'annons_ua', 'annons_en', 'mgr_content', 'mgr_content_ua', 'mgr_content_en', 'shuttle', 'shuttle_ua', 'shuttle_en', 'contacts', 'contacts_ua', 'contacts_en', 'on_foot', 'on_foot_ua', 'on_foot_en', 'by_car', 'by_car_ua', 'by_car_en', 'comment', 'comment_ua', 'comment_en'], 'string'],
            [['address', 'street', 'street_ua', 'street_en', 'redirect', 'email', 'email_name', 'name', 'name_ua', 'name_en', 'title', 'title_ua', 'title_en', 'keywords', 'keywords_ua', 'keywords_en', 'description', 'description_ua', 'description_en', 'stage_name', 'phone', 'pemail', 'fio', 'fio_ua', 'fio_en', 'pname', 'pname_ua', 'pname_en', 'ptitle', 'ptitle_ua', 'ptitle_en', 'pkeywords', 'pkeywords_ua', 'pkeywords_en', 'pdescription', 'pdescription_ua', 'pdescription_en'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
            'city_id' => Yii::t('app', 'City ID'),
            'country_id' => Yii::t('app', 'Country ID'),
            'district_id' => Yii::t('app', 'District ID'),
            'address' => Yii::t('app', 'Address'),
            'lat' => Yii::t('app', 'Lat'),
            'lng' => Yii::t('app', 'Lng'),
            'street' => Yii::t('app', 'Street'),
            'street_ua' => Yii::t('app', 'Street Ua'),
            'street_en' => Yii::t('app', 'Street En'),
            'lat_str' => Yii::t('app', 'Lat Str'),
            'lng_str' => Yii::t('app', 'Lng Str'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'class_id' => Yii::t('app', 'Class ID'),
            'percent_commission' => Yii::t('app', 'Percent Commission'),
            'active' => Yii::t('app', 'Active'),
            'contacts_admin' => Yii::t('app', 'Contacts Admin'),
            'hide' => Yii::t('app', 'Hide'),
            'redirect' => Yii::t('app', 'Redirect'),
            'hide_contacts' => Yii::t('app', 'Hide Contacts'),
            'email' => Yii::t('app', 'Email'),
            'email_name' => Yii::t('app', 'Email Name'),
            'approved' => Yii::t('app', 'Approved'),
            'total_m2' => Yii::t('app', 'Total M2'),
            'name' => Yii::t('app', 'Name'),
            'name_ua' => Yii::t('app', 'Name Ua'),
            'name_en' => Yii::t('app', 'Name En'),
            'content' => Yii::t('app', 'Content'),
            'content_ua' => Yii::t('app', 'Content Ua'),
            'content_en' => Yii::t('app', 'Content En'),
            'title' => Yii::t('app', 'Title'),
            'title_ua' => Yii::t('app', 'Title Ua'),
            'title_en' => Yii::t('app', 'Title En'),
            'keywords' => Yii::t('app', 'Keywords'),
            'keywords_ua' => Yii::t('app', 'Keywords Ua'),
            'keywords_en' => Yii::t('app', 'Keywords En'),
            'description' => Yii::t('app', 'Description'),
            'description_ua' => Yii::t('app', 'Description Ua'),
            'description_en' => Yii::t('app', 'Description En'),
            'annons' => Yii::t('app', 'Annons'),
            'annons_ua' => Yii::t('app', 'Annons Ua'),
            'annons_en' => Yii::t('app', 'Annons En'),
            'mgr_content' => Yii::t('app', 'Mgr Content'),
            'mgr_content_ua' => Yii::t('app', 'Mgr Content Ua'),
            'mgr_content_en' => Yii::t('app', 'Mgr Content En'),
            'shuttle' => Yii::t('app', 'Shuttle'),
            'shuttle_ua' => Yii::t('app', 'Shuttle Ua'),
            'shuttle_en' => Yii::t('app', 'Shuttle En'),
            'contacts' => Yii::t('app', 'Contacts'),
            'contacts_ua' => Yii::t('app', 'Contacts Ua'),
            'contacts_en' => Yii::t('app', 'Contacts En'),
            'on_foot' => Yii::t('app', 'On Foot'),
            'on_foot_ua' => Yii::t('app', 'On Foot Ua'),
            'on_foot_en' => Yii::t('app', 'On Foot En'),
            'by_car' => Yii::t('app', 'By Car'),
            'by_car_ua' => Yii::t('app', 'By Car Ua'),
            'by_car_en' => Yii::t('app', 'By Car En'),
            'pid' => Yii::t('app', 'Pid'),
            'pcreated_at' => Yii::t('app', 'Pcreated At'),
            'pupdated_at' => Yii::t('app', 'Pupdated At'),
            'item_id' => Yii::t('app', 'Item ID'),
            'm2' => Yii::t('app', 'M2'),
            'm2min' => Yii::t('app', 'M2min'),
            'valute_id' => Yii::t('app', 'Valute ID'),
            'stage_name' => Yii::t('app', 'Stage Name'),
            'price_period' => Yii::t('app', 'Price Period'),
            'ai' => Yii::t('app', 'Ai'),
            'commission' => Yii::t('app', 'Commission'),
            'opex' => Yii::t('app', 'Opex'),
            'plan_comment' => Yii::t('app', 'Plan Comment'),
            'phide' => Yii::t('app', 'Phide'),
            'archive' => Yii::t('app', 'Archive'),
            'price' => Yii::t('app', 'Price'),
            'con_price' => Yii::t('app', 'Con Price'),
            'tax' => Yii::t('app', 'Tax'),
            'kop' => Yii::t('app', 'Kop'),
            'phone' => Yii::t('app', 'Phone'),
            'pemail' => Yii::t('app', 'Pemail'),
            'status_id' => Yii::t('app', 'Status ID'),
            'rent' => Yii::t('app', 'Rent'),
            'hits' => Yii::t('app', 'Hits'),
            'phide_contacts' => Yii::t('app', 'Phide Contacts'),
            'comment' => Yii::t('app', 'Comment'),
            'fio' => Yii::t('app', 'Fio'),
            'comment_ua' => Yii::t('app', 'Comment Ua'),
            'fio_ua' => Yii::t('app', 'Fio Ua'),
            'comment_en' => Yii::t('app', 'Comment En'),
            'fio_en' => Yii::t('app', 'Fio En'),
            'pname' => Yii::t('app', 'Pname'),
            'pname_ua' => Yii::t('app', 'Pname Ua'),
            'pname_en' => Yii::t('app', 'Pname En'),
            'ptitle' => Yii::t('app', 'Ptitle'),
            'ptitle_ua' => Yii::t('app', 'Ptitle Ua'),
            'ptitle_en' => Yii::t('app', 'Ptitle En'),
            'pkeywords' => Yii::t('app', 'Pkeywords'),
            'pkeywords_ua' => Yii::t('app', 'Pkeywords Ua'),
            'pkeywords_en' => Yii::t('app', 'Pkeywords En'),
            'pdescription' => Yii::t('app', 'Pdescription'),
            'pdescription_ua' => Yii::t('app', 'Pdescription Ua'),
            'pdescription_en' => Yii::t('app', 'Pdescription En'),
            'hide_bc' => Yii::t('app', 'Hide Bc'),
            'no_bc' => Yii::t('app', 'No Bc'),
            'uah_price' => Yii::t('app', 'Uah Price'),
            'usd_price' => Yii::t('app', 'Usd Price'),
            'eur_price' => Yii::t('app', 'Eur Price'),
            'rub_price' => Yii::t('app', 'Rub Price'),
        ];
    }*/

    public function getBcitem()
    {
        return $this->hasOne(BcItems::className(), ['id' => 'id']);
    }
    public function getPlace()
    {
        return $this->hasOne(BcPlaces::className(), ['id' => 'pid']);
    }

}
