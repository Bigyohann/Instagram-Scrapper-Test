import React, {Fragment, useEffect, useState} from 'react';
import {IPosts} from "../Posts/Feed";
import styles from "./Search.module.scss"

interface ISearchProps {
    triggerButton(data: IPosts): void;
}

export const Search: React.FunctionComponent = (props: ISearchProps) => {

    const [username, setUsername] = useState('youtube');
    const [loading, setLoading] = useState(false);

    useEffect(() => {
        fetchData();
    }, []);


    const updateInput = (event) => {
        setUsername(event.target.value)
    }
    let fetchData = async () => {
        setLoading(true);
        const response = await fetch('/api/post/' + username, {
            method: 'GET',
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            }
        })
        const data: IPosts = await response.json();
        props.triggerButton(data);
        setLoading(false);
    }

    let submitForm = async (e) => {
        e.preventDefault();
        await fetchData();
    }

    return (
        <Fragment>
            <form onSubmit={submitForm} className={styles.form}>
                <input className={styles.input} type="text" value={username} onChange={updateInput}/>
                <button className={styles.button} type={"submit"}>Search</button>
            </form>
            {loading ? <div>Loading new datas</div> : ''}
        </Fragment>
    )
        ;
};
