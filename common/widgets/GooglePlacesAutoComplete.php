<?php
namespace common\widgets;

use yii\widgets\InputWidget;
use yii\helpers\Html;

class GooglePlacesAutoComplete extends InputWidget {
    public $libraries = 'places';
    public $autocompleteOptions = [
        'types' => ['geocode']
    ];
    public $geotype = 'address';
    /**
     * Renders the widget.
     */
    public function run(){
        $this->options['class'] = 'form-control';
        switch ($this->geotype) {
            case 'address':
                $this->options['id'] = 'address_autocomplate_name';
                break;
            case 'city':
                $this->options['id'] = 'city_autocomplate_name';
                break;
            case 'country':
                $this->options['id'] = 'country_autocomplate_name';
                break;
            case 'district':
                $this->options['id'] = 'district_autocomplate_name';
                break;
            default:
                break;
        }
        $this->registerClientScript();
        if ($this->hasModel()) {
            echo Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textInput($this->name, $this->value, $this->options);
        }
    }
    /**
     * Registers the needed JavaScript.
     */
    public function registerClientScript(){
        $elementId = $this->options['id'];
        $scriptOptions = json_encode($this->autocompleteOptions);
        $view = $this->getView();
        $view->registerJs(<<<JS
(function(){
    var input = document.getElementById('{$elementId}');
    var options = {$scriptOptions};
    var geotype = '{$this->geotype}';
    var place;
    autocomplete = new google.maps.places.Autocomplete(input, options);
    autocomplete.setFields(['address_component', 'geometry']);
    autocomplete.addListener('place_changed', fillInAddress);
        //console.log(autocomplete.getPlace());

    function fillInAddress() {
      // Get the place details from the autocomplete object.
        if(place = autocomplete.getPlace()){
        if (!place.geometry) {
              // User entered the name of a Place that was not suggested and
              // pressed the Enter key, or the Place Details request failed.
              window.alert("No details available for input: '" + place.name + "'");
              return;
            }
            //console.log(place);
        if(geotype=='address'){
         $('#address_autocomplate_value').val(place.geometry.location.lat()+','+place.geometry.location.lng());
        }
        console.log(place.geometry.location.lat());
      } else{
      alert('error');
      }
      }
})();
JS
            , \yii\web\View::POS_READY);
    }
}