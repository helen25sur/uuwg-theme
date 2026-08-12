(function (blocks, element, blockEditor, components, i18n, data) {

  const { registerBlockType } = blocks;
  const { useBlockProps, InspectorControls, RichText } = blockEditor;
  const { PanelBody, TextControl, Spinner } = components;
  const { __ } = i18n;
  const { useSelect } = data;
  const el = element.createElement;

  registerBlockType('uuwg/partners-collaborations', {
    edit: function (props) {
      const { attributes, setAttributes } = props;
      const { heading, headerText, buttonText, buttonUrl, cardWidth, gap } = attributes;

      const blockProps = useBlockProps({ className: 'uuwg-partners-collaborations' });

      const { partners } = useSelect(
        function (select) {
          return {
            partners: select('core').getEntityRecords('postType', 'partner', { per_page: -1, _embed: true })
          };
        },
        []
      );

      const inspector = el(
        InspectorControls,
        {},
        el(
          PanelBody,
          { title: __('Block Settings', 'uuwg'), initialOpen: true },
          el(TextControl, {
            label: __('Width of the logo (px)', 'uuwg'),
            type: 'number',
            value: cardWidth,
            onChange: (v) => setAttributes({ cardWidth: parseInt(v, 10) || 0 }),
          }),
          el(TextControl, {
            label: __('Gap between logos (px)', 'uuwg'),
            type: 'number',
            value: gap,
            onChange: (v) => setAttributes({ gap: parseInt(v, 10) || 0 }),
          }),
          el(TextControl, {
            label: __('URL of the button', 'uuwg'),
            type: 'url',
            value: buttonUrl,
            onChange: (v) => setAttributes({ buttonUrl: v }),
          })
        )
      );

      let partnersRow;

      if (partners === null) {
        partnersRow = el('div', { className: 'uuwg-partners-collaborations__loading' }, el(Spinner), ' ', __('Downloading...', 'uuwg'));
      } else if (partners.length === 0) {
        partnersRow = el('p', { className: 'uuwg-partners-collaborations__empty' }, __('Not found.', 'uuwg'));
      } else {
        partnersRow = partners.map(function (partner) {
          const media = partner._embedded && partner._embedded['wp:featuredmedia'] ? partner._embedded['wp:featuredmedia'][0] : null;
          const imageUrl = media ? (media.media_details?.sizes?.medium?.source_url || media.source_url) : '';

          return el(
            'div',
            {
              key: partner.id,
              className: 'uuwg-partners-collaborations__card',
              style: { width: (cardWidth || 196) + 'px' }
            },
            imageUrl
              ? el('img', { src: imageUrl, alt: partner.title.rendered })
              : el('span', {}, partner.title.rendered)
          );
        });
      }

      return el(
        'div',
        blockProps,
        inspector,
        el(
          'div',
          { className: 'uuwg-partners-collaborations__content' },

          // Header Section
          el(
            'div',
            { className: 'uuwg-partners-collaborations__header' },
            el(RichText, {
              tagName: 'h2',
              className: 'uuwg-partners-collaborations__heading',
              value: heading,
              onChange: (v) => setAttributes({ heading: v }),
              placeholder: __('Heading...', 'uuwg')
            }),
            el(RichText, {
              tagName: 'p',
              className: 'uuwg-partners-collaborations__header-text',
              value: headerText,
              onChange: (v) => setAttributes({ headerText: v }),
              placeholder: __('Header description...', 'uuwg')
            })
          ),

          // Partners Row
          el('div', {
            className: 'uuwg-partners-collaborations__row',
            style: { gap: (gap || 24) + 'px' }
          }, partnersRow),

          // CTA Button
          el(
            'a',
            {
              className: 'uuwg-partners-collaborations__cta uuwg-btn',
              href: buttonUrl || '#',
              onClick: (e) => e.preventDefault()
            },
            el(RichText, {
              tagName: 'span',
              value: buttonText,
              onChange: (v) => setAttributes({ buttonText: v }),
              placeholder: __('Button text...', 'uuwg'),
              allowedFormats: []
            })
          )
        )
      );
    },
    save: function () { return null; },
  });
})(
  window.wp.blocks,
  window.wp.element,
  window.wp.blockEditor,
  window.wp.components,
  window.wp.i18n,
  window.wp.data
);