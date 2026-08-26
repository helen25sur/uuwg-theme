(function (blocks, element, blockEditor, components, i18n, data) {
  const { registerBlockType } = blocks;
  const {
    useBlockProps,
    InspectorControls,
    RichText,
    MediaUpload,
    MediaUploadCheck
  } = blockEditor;
  const { PanelBody, TextControl, Spinner, Button } = components;
  const { __ } = i18n;
  const { useSelect } = data;
  const el = element.createElement;

  registerBlockType('uuwg/documents-grid', {
    edit: function (props) {
      const { attributes, setAttributes } = props;
      const { heading, folderIconUrl } = attributes;

      const blockProps = useBlockProps({
        className: 'uuwg-documents-grid alignfull'
      });

      const { documents, documentTypes } = useSelect(
        function (select) {
          const core = select('core');

          return {
            documents: core.getEntityRecords('postType', 'document', {
              per_page: -1,
              _embed: true
            }),

            documentTypes: core.getEntityRecords('taxonomy', 'document_type', {
              per_page: -1
            })
          };
        },
        []
      );

      let documentsGrid;

      if (documents === null || documentTypes === null) {
        documentsGrid = el(
          'div',
          { className: 'uuwg-documents-grid__loading' },
          el(Spinner),
          ' ',
          __('Loading...', 'uuwg')
        );
      } else if (documents.length === 0) {
        documentsGrid = el(
          'p',
          { className: 'uuwg-documents-grid__empty' },
          __('No documents found.', 'uuwg')
        );
      } else {
        documentsGrid = documents.map(function (doc) {
          const types = (doc.document_type || [])
            .map(function (typeId) {
              return documentTypes.find(function (type) {
                return type.id === typeId;
              });
            })
            .filter(Boolean);

          return el(
            'div',
            {
              className: 'uuwg-documents-grid__card',
              key: doc.id
            },

            el(
              'div',
              { className: 'uuwg-documents-grid__card__img' },
              el('img', {
                src: folderIconUrl || '/wp-content/themes/uuwg-theme/assets/images/folder.png',
                alt: ''
              })
            ),

            el(
              'div',
              { className: 'uuwg-documents-grid__card__content' },

              el('h3', {
                className: 'uuwg-documents-grid__card__title',
                dangerouslySetInnerHTML: {
                  __html: doc.title.rendered
                }
              }),

              types.length > 0 &&
              el(
                'div',
                { className: 'uuwg-documents-grid__card__type' },
                types.map(function (type) {
                  return el(
                    'span',
                    {
                      className: 'uuwg-documents-grid__card__type-name',
                      key: type.id
                    },
                    type.name
                  );
                })
              ),

              el(
                'span',
                {
                  className: 'uuwg-documents-grid__card__button'
                },
                __('Download', 'uuwg')
              )
            )
          );
        });
      }

      return el(
        'div',
        blockProps,

        el(
          InspectorControls,
          {},
          el(
            PanelBody,
            {
              title: __('Documents settings', 'uuwg'),
              initialOpen: true
            },

            el(TextControl, {
              label: __('Heading', 'uuwg'),
              value: heading || '',
              onChange: function (value) {
                setAttributes({ heading: value });
              }
            }),

            el(
              MediaUploadCheck,
              {},
              el(MediaUpload, {
                allowedTypes: ['image'],
                value: folderIconUrl,
                onSelect: function (media) {
                  setAttributes({
                    folderIconUrl: media.url
                  });
                },
                render: function ({ open }) {
                  return el(
                    'div',
                    { className: 'uuwg-documents-grid__icon-control' },

                    el(
                      'p',
                      { className: 'components-base-control__label' },
                      __('Folder icon', 'uuwg')
                    ),

                    folderIconUrl &&
                    el('img', {
                      src: folderIconUrl,
                      alt: '',
                      style: {
                        display: 'block',
                        maxWidth: '100px',
                        marginBottom: '10px'
                      }
                    }),

                    el(
                      Button,
                      {
                        onClick: open,
                        variant: 'secondary'
                      },
                      folderIconUrl
                        ? __('Change icon', 'uuwg')
                        : __('Upload icon', 'uuwg')
                    )
                  );
                }
              })
            )
          )
        ),

        el(
          'div',
          { className: 'uuwg-documents-grid__content' },

          el(
            'div',
            { className: 'uuwg-documents-grid__header' },
            el(RichText, {
              tagName: 'h2',
              className: 'uuwg-documents-grid__heading',
              value: heading,
              onChange: function (value) {
                setAttributes({ heading: value });
              },
              allowedFormats: []
            })
          ),

          el(
            'div',
            { className: 'uuwg-documents-grid__grid' },
            documentsGrid
          )
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
  window.wp.components,
  window.wp.i18n,
  window.wp.data
);