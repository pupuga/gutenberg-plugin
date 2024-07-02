import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { useSelect } from '@wordpress/data';
import { useEntityProp } from '@wordpress/core-data';
import Redactor from './Redactor';
import Panel from './Panel';

const EditBlock = ( props ) => {
	const blockName = useBlockProps()[ 'data-type' ]?.split( '/' )[ 1 ];

	const postType = useSelect(
		( select ) => select( 'core/editor' ).getCurrentPostType(),
		[]
	);

	const [ meta, setMeta ] = useEntityProp( 'postType', postType, 'meta' );

	const updatedProps = {
		...props,
		...{
			blockName: blockName,
			metaName: `_${ blockName }`,
			meta: meta,
			updateMeta: ( slug, value ) =>
				setMeta( { ...meta, [ slug ]: value } ),
		},
	};

	return (
		<>
			<InspectorControls>
				<Panel { ...updatedProps } />
			</InspectorControls>
			<div { ...useBlockProps() }>
				<Redactor { ...updatedProps } />
			</div>
		</>
	);
};

export default EditBlock;
