import {useBlockProps} from "@wordpress/block-editor";

export default function save( {attributes} ) {
    return <h3 {...useBlockProps.save()}>{ attributes.title }</h3>;
}