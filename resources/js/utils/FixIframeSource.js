export function fixIframe(src) {
  var start_tag_replaced = src.replace('<p>&lt;iframe', '<iframe');
  var end_tag_replaced = start_tag_replaced.replace('&gt;&lt;/iframe&gt;</p>', '></iframe>');
  return end_tag_replaced;
}