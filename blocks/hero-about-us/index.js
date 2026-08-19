(function (blocks, blockEditor, components, element, i18n) {
  const { registerBlockType } = blocks;
  const { useBlockProps, RichText, InspectorControls, MediaUpload, MediaUploadCheck } = blockEditor;
  const { PanelBody, TextControl, Button } = components;
  const el = element.createElement;
  const __ = i18n.__;

  const themeUri = (window.uuwgThemeData && window.uuwgThemeData.themeUri) || '';
  const defaultsBase = themeUri + '/assets/images/about-us/';

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


  registerBlockType('uuwg/hero-about-us', {

    edit: function (props) {
      const { attributes, setAttributes } = props;
      const {
        title,
        subtitle,
        yellowButtonText,
        yellowButtonUrl,
        secondaryButtonText,
        secondaryButtonUrl,
        photo1Id, photo1Url, photo2Id, photo2Url, photo3Id, photo3Url,
        photo4Id, photo4Url, photo5Id, photo5Url, photo6Id, photo6Url,
      } = attributes;

      const blockProps = useBlockProps({
        className: 'uuwg-hero-about-us',
      });

      const preview1 = photo1Url || defaultsBase + 'about-us-01.png';
      const preview2 = photo2Url || defaultsBase + 'about-us-02.png';
      const preview3 = photo3Url || defaultsBase + 'about-us-03.png';
      const preview4 = photo4Url || defaultsBase + 'about-us-04.png';
      const preview5 = photo5Url || defaultsBase + 'about-us-05.png';
      const preview6 = photo6Url || defaultsBase + 'about-us-06.jpg';


      const inspector = el(
        InspectorControls,
        {},
        el(
          PanelBody,
          { title: __('Кнопки', 'uuwg'), initialOpen: true },
          el(TextControl, {
            label: __('Текст першої кнопки', 'uuwg'),
            value: yellowButtonText,
            onChange: function (value) {
              setAttributes({ yellowButtonText: value });
            },
          }),
          el(TextControl, {
            label: __('URL першої кнопки', 'uuwg'),
            value: yellowButtonUrl,
            onChange: function (value) {
              setAttributes({ yellowButtonUrl: value });
            },
          }),
          el(TextControl, {
            label: __('Текст другої кнопки', 'uuwg'),
            value: secondaryButtonText,
            onChange: function (value) {
              setAttributes({ secondaryButtonText: value });
            },
          }),
          el(TextControl, {
            label: __('URL другої кнопки', 'uuwg'),
            value: secondaryButtonUrl,
            onChange: function (value) {
              setAttributes({ secondaryButtonUrl: value });
            },
          }),
          el(
            PanelBody,
            { title: 'Фото 1 (верхнє ліве)', initialOpen: false },
            photoUploadControl('photo 1', photo1Id, photo1Url, (media) =>
              setAttributes({ photo1Id: media.id, photo1Url: media.url })
            )),
          el(
            PanelBody,
            { title: 'Фото 2 (верхнє праве)', initialOpen: false },
            photoUploadControl('photo 2', photo2Id, photo2Url, (media) =>
              setAttributes({ photo2Id: media.id, photo2Url: media.url })
            )),
          el(
            PanelBody,
            { title: 'Фото 3 (нижнє крайнє ліве)', initialOpen: false },
            photoUploadControl('photo 3', photo3Id, photo3Url, (media) =>
              setAttributes({ photo3Id: media.id, photo3Url: media.url })
            )),
          el(
            PanelBody,
            { title: 'Фото 4 (нижнє друге зліва', initialOpen: false },
            photoUploadControl('photo 4', photo4Id, photo4Url, (media) =>
              setAttributes({ photo4Id: media.id, photo4Url: media.url })
            )),
          el(
            PanelBody,
            { title: 'Фото 5 (нижнє третє зліва)', initialOpen: false },
            photoUploadControl('photo 5', photo5Id, photo5Url, (media) =>
              setAttributes({ photo5Id: media.id, photo5Url: media.url })
            )),
          el(
            PanelBody,
            { title: 'Фото 6 (нижнє крайнє справа)', initialOpen: false },
            photoUploadControl('photo 6', photo6Id, photo6Url, (media) =>
              setAttributes({ photo6Id: media.id, photo6Url: media.url })
            ))
        )
      );

      return el(
        'section',
        blockProps,
        inspector,
        el(RichText, {
          tagName: 'h1',
          className: 'uuwg-hero-about-us__title',
          value: title,
          onChange: function (value) {
            setAttributes({ title: value });
          },
          placeholder: __('Заголовок банера…', 'uuwg'),
          allowedFormats: [],
        }),
        el(RichText, {
          tagName: 'p',
          className: 'uuwg-hero-about-us__subtitle',
          value: subtitle,
          onChange: function (value) {
            setAttributes({ subtitle: value });
          },
          placeholder: __('Підзаголовок…', 'uuwg'),
        }),
        el(
          'div',
          { className: 'uuwg-hero-about-us__buttons' },
          el(RichText, {
            tagName: 'span',
            className: 'uuwg-hero-about-us__button uuwg-hero-about-us__button--primary wp-element-button',
            value: yellowButtonText,
            onChange: function (value) {
              setAttributes({ yellowButtonText: value });
            },
            allowedFormats: [],
          }),
          el(RichText, {
            tagName: 'span',
            className: 'uuwg-hero-about-us__button uuwg-hero-about-us__button--secondary',
            value: secondaryButtonText,
            onChange: function (value) {
              setAttributes({ secondaryButtonText: value });
            },
            allowedFormats: [],
          })
        ),

        el(
          'div',
          { className: 'uuwg-hero-about-us__photos' },
          el(
            'div',
            { className: 'uuwg-hero-about-us__photo uuwg-hero-about-us__photo--1' },
            el('img', { src: preview1, alt: '' })
          ),
          el(
            'div',
            { className: 'uuwg-hero-about-us__photo uuwg-hero-about-us__photo--2' },
            el('img', { src: preview2, alt: '' })
          ),
          el(
            'div',
            { className: 'uuwg-hero-about-us__photo uuwg-hero-about-us__photo--3' },
            el('img', { src: preview3, alt: '' })
          ),
          el(
            'div',
            { className: 'uuwg-hero-about-us__photo uuwg-hero-about-us__photo--4' },
            el('img', { src: preview4, alt: '' })
          ),
          el(
            'div',
            { className: 'uuwg-hero-about-us__photo uuwg-hero-about-us__photo--5' },
            el('img', { src: preview5, alt: '' })
          ),
          el(
            'div',
            { className: 'uuwg-hero-about-us__photo uuwg-hero-about-us__photo--6' },
            el('img', { src: preview6, alt: '' })
          )
        )
      );
    },

    save: function () {
      return null;
    },

    deprecated: [
      {
        save: function (props) {
          const { attributes } = props;
          const {
            title,
            subtitle,
            yellowButtonText,
            secondaryButtonText,
          } = attributes;

          const blockProps = blockEditor.useBlockProps.save({
            className: 'uuwg-hero-about-us',
          });

          return el(
            'div',
            blockProps,
            el(RichText.Content, {
              tagName: 'h1',
              className: 'uuwg-hero-about-us__title',
              value: title,
            }),
            el(RichText.Content, {
              tagName: 'p',
              className: 'uuwg-hero-about-us__subtitle',
              value: subtitle,
            }),
            el(
              'div',
              { className: 'uuwg-hero-about-us__buttons' },
              el('span', { className: 'uuwg-hero-about-us__button' }, yellowButtonText),
              el('span', { className: 'uuwg-hero-about-us__button' }, secondaryButtonText)
            )
          );
        },
      },
    ],
  });
})(
  window.wp.blocks,
  window.wp.blockEditor,
  window.wp.components,
  window.wp.element,
  window.wp.i18n
);