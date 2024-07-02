import { Suspense, lazy } from 'react';
import { __ } from '@wordpress/i18n';
import { PanelBody, PanelRow } from '@wordpress/components';

let Component = null;
let updatedFields = null;

const Panel = ( props ) => {
	if ( Component === null ) {
		Component = lazy( () =>
			import( `../../../${ props.blockName }/EditBlock/Panel/Panel` )
		);
	}

	if ( updatedFields === null ) {
		updatedFields = props.fields.map( ( field ) => {
			const slug = field.slug.replace(
				/^./,
				field.slug[ 0 ].toUpperCase()
			);
			return {
				...field,
				Component: lazy( () =>
					import(
						`../../${ props.blockName }/EditBlock/Panel/${ slug }`
					)
				),
			};
		} );
	}

	return (
		<div className="blocks-panel">
			{ Component === null ? (
				''
			) : (
				<Suspense fallback={ <div>Loading...</div> }>
					<Component { ...props } />
				</Suspense>
			) }
			{ updatedFields.map( ( field, index ) => {
				const Component = field.Component;
				return (
					<Suspense key={ index } fallback={ <div>Loading...</div> }>
						<PanelBody title={ __( field.title ) }>
							<PanelRow>
								<Component
									{ ...{
										...props,
										metaFieldName: `${ props.metaName }_${ field.slug }`,
									} }
								/>
							</PanelRow>
						</PanelBody>
					</Suspense>
				);
			} ) }
		</div>
	);
};

export default Panel;
