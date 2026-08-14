(function (blocks, element, blockEditor, components) {

  const { registerBlockType } = blocks;
  const { useBlockProps, InspectorControls, RichText, MediaUpload, MediaUploadCheck } = blockEditor;
  const { PanelBody, TextControl, Button } = components;
  const el = element.createElement;

  const themeUri = (window.uuwgThemeData && window.uuwgThemeData.themeUri) || '';
  const defaultsBase = themeUri + '/assets/images/mission/';

  function photoUploadControl(label, currentId, currentUrl, onSelect) {
    return el(
      MediaUploadCheck,
      {},
      el(MediaUpload, {
        onSelect: onSelect,
        allowedTypes: ['image'],
        value: currentId || '',
        render: function (obj) {
          return el(
            Button,
            { onClick: obj.open, variant: 'secondary' },
            currentUrl ? 'Change ' + label : 'Select ' + label
          );
        },
      })
    );
  }

  registerBlockType('uuwg/mission', {

    edit: function (props) {
      const { attributes, setAttributes } = props;
      const {
        heading, paragraph1, paragraph2, buttonText, buttonUrl,
        photo1Id, photo1Url, photo1Badge,
        photo2Id, photo2Url, photo2Badge,
        photo3Id, photo3Url,
        connectingBadgeText,
      } = attributes;

      const blockProps = useBlockProps({ className: 'uuwg-mission' });

      const preview1 = photo1Url || defaultsBase + 'photo-1.jpg';
      const preview2 = photo2Url || defaultsBase + 'photo-2.jpg';
      const preview3 = photo3Url || defaultsBase + 'photo-3.jpg';

      const inspector = el(
        InspectorControls,
        {},
        el(
          PanelBody,
          { title: 'Кнопка', initialOpen: true },
          el(TextControl, {
            label: 'Текст кнопки',
            value: buttonText,
            onChange: (v) => setAttributes({ buttonText: v }),
          }),
          el(TextControl, {
            label: 'URL кнопки',
            value: buttonUrl,
            onChange: (v) => setAttributes({ buttonUrl: v }),
          })
        ),
        el(
          PanelBody,
          { title: 'Фото 1 (верхнє ліве)', initialOpen: false },
          photoUploadControl('photo 1', photo1Id, photo1Url, (media) =>
            setAttributes({ photo1Id: media.id, photo1Url: media.url })
          ),
          el(TextControl, {
            label: 'Текст бейджа (порожньо — сховати)',
            value: photo1Badge,
            onChange: (v) => setAttributes({ photo1Badge: v }),
          })
        ),
        el(
          PanelBody,
          { title: 'Плаваючий бейдж "Connecting"', initialOpen: false },
          el(TextControl, {
            label: 'Текст бейджа',
            value: connectingBadgeText,
            onChange: (v) => setAttributes({ connectingBadgeText: v }),
          })
        ),
        el(
          PanelBody,
          { title: 'Фото 2 (нижнє ліве)', initialOpen: false },
          photoUploadControl('photo 2', photo2Id, photo2Url, (media) =>
            setAttributes({ photo2Id: media.id, photo2Url: media.url })
          ),
          el(TextControl, {
            label: 'Текст бейджа (порожньо — сховати)',
            value: photo2Badge,
            onChange: (v) => setAttributes({ photo2Badge: v }),
          })
        ),
        el(
          PanelBody,
          { title: 'Фото 3 (праве, високе)', initialOpen: false },
          photoUploadControl('photo 3', photo3Id, photo3Url, (media) =>
            setAttributes({ photo3Id: media.id, photo3Url: media.url })
          )
        )
      );

      return el(
        'div',
        blockProps,
        inspector,

        el(
          'div',
          { className: 'uuwg-mission__text' },
          el(RichText, {
            tagName: 'h2',
            className: 'uuwg-mission__heading',
            value: heading,
            onChange: (v) => setAttributes({ heading: v }),
            allowedFormats: [],
          }),
          el(RichText, {
            tagName: 'p',
            className: 'uuwg-mission__paragraph',
            value: paragraph1,
            onChange: (v) => setAttributes({ paragraph1: v }),
          }),
          el(RichText, {
            tagName: 'p',
            className: 'uuwg-mission__paragraph',
            value: paragraph2,
            onChange: (v) => setAttributes({ paragraph2: v }),
          }),
          el(RichText, {
            tagName: 'span',
            className: 'uuwg-mission__button wp-element-button',
            value: buttonText,
            onChange: (v) => setAttributes({ buttonText: v }),
            allowedFormats: [],
          })
        ),

        el(
          'div',
          { className: 'uuwg-mission__collage' },

          el(
            'div',
            { className: 'uuwg-mission__photo uuwg-mission__photo--1' },
            el(
              'div',
              { className: 'uuwg-mission__photo-frame' },
              el('img', { src: preview1, alt: '' })
            ),
            photo1Badge &&
            el('span', { className: 'uuwg-mission__badge uuwg-mission__badge--top-right' }, photo1Badge)
          ),

          connectingBadgeText &&
          el('span', { className: 'uuwg-mission__badge uuwg-mission__badge--floating' }, connectingBadgeText),

          el(
            'div',
            { className: 'uuwg-mission__photo uuwg-mission__photo--2' },
            el(
              'div',
              { className: 'uuwg-mission__photo-frame' },
              el('img', { src: preview2, alt: '' })
            ),
            photo2Badge &&
            el('span', { className: 'uuwg-mission__badge uuwg-mission__badge--top-right' }, photo2Badge)
          ),

          el(
            'div',
            { className: 'uuwg-mission__photo uuwg-mission__photo--3' },
            el(
              'div',
              { className: 'uuwg-mission__photo-frame' },
              el('img', { src: preview3, alt: '' })
            )
          )
        )
      );
    },

    save: function () {
      return null;
    },

  });

})(
  window.wp.blocks,
  window.wp.element,
  window.wp.blockEditor,
  window.wp.components
);