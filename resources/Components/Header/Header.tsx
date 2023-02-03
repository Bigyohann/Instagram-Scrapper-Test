import React from "react"
import styles from "./Header.module.scss";

export const Header : React.FunctionComponent = () => {
    return (
        <header>
            <div className={styles.wrapper}>
                <h1 className={styles.title}>Instagram Profile Retriever</h1>
            </div>
        </header>
    )
}
