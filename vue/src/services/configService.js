const apiBaseUrl = 'http://ashesdb.local:8080/app_dev.php';
const imageBaseUrl = 'http://ashesdb.local:8080/bundles/card_images/';

export default {
  apiBaseUrl,
  getCardImageURL(card) {
    return `${imageBaseUrl + card.code}.jpg`;
  },
};
