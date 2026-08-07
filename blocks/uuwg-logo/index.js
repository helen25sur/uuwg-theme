(function (blocks, element, blockEditor, components) {

  const { registerBlockType } = blocks;
  const { useBlockProps, InspectorControls, MediaUpload, MediaUploadCheck } = blockEditor;
  const { PanelBody, Button } = components;
  const el = element.createElement;

  // Дефолтні шляхи, узгоджені з render.php
  const themeUri = (window.uuwgThemeData && window.uuwgThemeData.themeUri) || '';
  const defaultDarkLogo = themeUri + '/assets/images/logo-default-blue.svg';
  const defaultLightLogo = themeUri + '/assets/images/logo-default-white.svg';

  registerBlockType('uuwg/uuwg-logo', {

    edit: function (props) {

      const { attributes, setAttributes } = props;
      const { darkLogo, lightLogo } = attributes;

      const blockProps = useBlockProps({ className: 'uuwg-site-logo-editor' });

      const selectDarkLogo = function (media) {
        setAttributes({ darkLogo: { id: media.id, url: media.url } });
      };

      const selectLightLogo = function (media) {
        setAttributes({ lightLogo: { id: media.id, url: media.url } });
      };

      // Прев'ю показує кастомний логотип, якщо обраний, інакше — дефолт із теми
      const previewUrl = (darkLogo && darkLogo.url) ? darkLogo.url : defaultDarkLogo;

      return el(
        element.Fragment,
        {},

        el(
          InspectorControls,
          {},
          el(
            PanelBody,
            { title: 'Logo settings', initialOpen: true },

            el(MediaUploadCheck, {},
              el(MediaUpload, {
                onSelect: selectDarkLogo,
                allowedTypes: ['image'],
                value: darkLogo ? darkLogo.id : '',
                render: function (obj) {
                  return el(Button, { onClick: obj.open, variant: 'secondary' },
                    darkLogo ? 'Change dark logo' : 'Use custom dark logo (default: blue)'
                  );
                }
              })
            ),

            el(MediaUploadCheck, {},
              el(MediaUpload, {
                onSelect: selectLightLogo,
                allowedTypes: ['image'],
                value: lightLogo ? lightLogo.id : '',
                render: function (obj) {
                  return el(Button, { onClick: obj.open, variant: 'secondary' },
                    lightLogo ? 'Change light logo' : 'Use custom light logo (default: white)'
                  );
                }
              })
            )
          )
        ),

        el('div', blockProps,
          el('img', {
            src: previewUrl,
            alt: 'Logo preview',
            style: { maxWidth: '180px', height: 'auto' }
          })
        )
      );
    },

    save: function () {
      return null;
    }

  });

})(
  window.wp.blocks,
  window.wp.element,
  window.wp.blockEditor,
  window.wp.components
);