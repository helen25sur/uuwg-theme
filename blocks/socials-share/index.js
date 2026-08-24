(function (blocks, element, blockEditor, components) {

  const { registerBlockType } = blocks;
  const { useBlockProps, InspectorControls, MediaUploadCheck, MediaUpload } = blockEditor;
  const { TextControl, Button } = components;
  const el = element.createElement;

  registerBlockType('uuwg/socials-share', {

    edit: function (props) {
      const { attributes, setAttributes } = props;

      const blockProps = useBlockProps({ className: 'uuwg-socials-share' });

      const buttonsList = [1, 2, 3, 4, 5, 6].map(function (n) {
        const icon = `button${n}Icon`;
        const label = `button${n}Label`;

        return el(
          MediaUploadCheck,
          { key: n },
          [
            el(MediaUpload, {
              allowedTypes: ['image'],
              value: attributes[icon],
              onSelect: (media) => {
                setAttributes({ [icon]: media.url });
              },
              render: ({ open }) =>
                el(
                  Button,
                  {
                    onClick: open,
                    variant: 'secondary',
                  },
                  attributes[icon]
                    ? `Change Button ${n} icon`
                    : `Upload Button ${n} icon`
                ),
            }),

            el(TextControl, {
              label: `Button ${n} accessible label`,
              value: attributes[label],
              onChange: (v) => setAttributes({ [label]: v }),
            }),
          ]
        );
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
          { className: 'uuwg-socials-share__list' },
          [1, 2, 3, 4, 5, 6].map(function (n) {
            return el(
              'button',
              {
                className: 'uuwg-socials-share__button',
                key: n,
              },
              el('img', {
                src: attributes[`button${n}Icon`],
                className: 'uuwg-socials-share__button__icon',
                alt: '',
              })
            );
          })
        )
      )
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