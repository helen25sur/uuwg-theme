(function (blocks, element, blockEditor, components) {
  const { registerBlockType } = blocks;
  const { useBlockProps, InspectorControls } = blockEditor;
  const { TextControl } = components;
  const el = element.createElement;

  const socials = [
    'instagram',
    'facebook',
    'youtube',
    'linkedin',
    'telegram',
    'copy',
  ];

  registerBlockType('uuwg/socials-share', {
    edit: function (props) {
      const { attributes, setAttributes } = props;

      const blockProps = useBlockProps({
        className: 'uuwg-socials-share',
      });

      const buttonsList = socials.map(function (social) {
        const label = `${social}Label`;

        return el(TextControl, {
          label: `${social} accessible label`,
          value: attributes[label],
          onChange: (value) => setAttributes({ [label]: value }),
          key: social,
        });
      });

      return el(
        'div',
        blockProps,

        el(
          InspectorControls,
          {},
          buttonsList
        ),

        el(
          'div',
          {
            className: 'uuwg-socials-share__list',
          },

          socials.map(function (social) {
            const label = `${social}Label`;

            return el(
              'button',
              {
                className: 'uuwg-socials-share__button',
                key: social,
                type: 'button',
              },
              el('span', {
                className: 'uuwg-socials-share__button__icon',
                style: {
                  '--icon-url': `url("${window.uuwgTheme.socialIconsUrl}/${social}.svg")`,
                },
              })
            );
          })
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