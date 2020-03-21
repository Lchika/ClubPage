export function imgsrc(src) {
  try {
    let parsed_obj = getParsedObject(src)
    let dst = {}
    dst = getImgSrcs(parsed_obj)
    return dst
  } catch (e) {
    alert(e)
  }
  return dst
}

function getParsedObject(str_html) {
  let parser = new DOMParser()
  let doc = parser.parseFromString(str_html, "text/html")
  return doc
}

function getImgSrcs(doc) {
  return Array.from(
    doc.images,
    (e) => {
      return { src: e.getAttribute("src").toString() }
    }
  )
}