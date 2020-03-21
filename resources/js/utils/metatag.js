export function metatag(title, description, image_path, logo_path) {
  return {
    title: title,
    meta: [
      {name: 'description', content: description},
      {property: 'twitter:card', content: 'summary'},
      {property: 'twitter:title', content: title + ' | メカトロ同好会エルチカ'},
      //{property: 'twitter:site', content: '@anonymous'},
      //{property: 'twitter:creator', content: '@anonymous'},
      {property: 'twitter:description', content: description},
      {
        property: 'twitter:image',
        content: image_path,
      },
      {property: 'og:title', content: title + ' | メカトロ同好会エルチカ'},
      {property: 'og:description', content: description},
      {property: 'og:type', content: 'website'},
      {property: 'og:url', content: location.href},
      {
        property: 'og:image',
        content: image_path,
      },
    ],
    script: [
      {
        type: 'application/ld+json',
        innerHTML: JSON.stringify(
          [{
            '@context': 'http://schema.org',
            '@type': 'Organization',
            'url': location.href,
            'logo': logo_path,
          },
            {
              '@context': 'http://schema.org',
              '@type': 'WebSite',
              'name': title + ' | メカトロ同好会エルチカ',
              'alternateName': description,
              'url': location.href,
            },
          ], null, 2,
        ),
      },
    ],
  };
}