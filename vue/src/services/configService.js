let api_base_url = 'http://ashesdb.local:8080/app_dev.php'
let image_base_url = 'http://ashesdb.local:8080/bundles/card_images/'

export default {
  api_base_url,
  getCardImageURL: function (card) {
    return image_base_url + card.code + '.jpg'
  }
}
