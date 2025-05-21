import { useState, useEffect, useRef } from 'react';
import { useNavigate, useParams } from 'react-router-dom';

import { getCompanies } from "./../companies/other/companies_service.js";
import { getCustomer } from "./other/customer_service.js";

import { dtoCustomersEdit } from "./../../../dto/customers/dto_customers_edit.ts";

//会社モーダル画面関連
import useModalController from "./../companies/modal_controller.js";
import CompaniesListModal from "./../companies/modal/modal_company_list.js";
import CompaniesEntryModal from "./../companies/modal/modal_company_entry.js";
import CompaniesEditModal from "./../companies/modal/modal_company_edit.js";

function CustomerEditPage() {
    const {
        currentModal,
        editCompanyId,
        openCompanyList,
        openCompanyEntry,
        openCompanyEdit,
        closeModal,
    } = useModalController();
    const prevModal = useRef(currentModal);
    const { cust_id } = useParams();
    const navigate = useNavigate();

    const [name, setName] = useState('');
    const [nameKana, setNameKana] = useState('');
    const [mailAddress, setMailAddress] = useState('');
    const [phoneNumber, setPhoneNumber] = useState('');
    const [sex, setSex] = useState('男性');
    const [bornDate, setBornDate] = useState('');
    const [company, setCompany] = useState('');
    
    //会社一覧データ
    const [companiesData, setCompaniesData] = useState([]);

    useEffect(() => {
        const fetchCompanies = async () => {
            setCompaniesData(await getCompanies());
            const customer = await getCustomer(cust_id);
            if(!customer || Object.keys(customer).length === 0)
            {
                alert("指定の顧客が見つかりませんでした。");
                navigate("/cust_list");
            }
            setName(customer.cust_name);
            setNameKana(customer.cust_name_kana);
            setMailAddress(customer.mail_address);
            setPhoneNumber(customer.phone_number);
            setSex(customer.sex);
            setBornDate(customer.born_date);
            setCompany(customer.company_id);
        }
        fetchCompanies();
    }, []);  // ← 空配列にすると初回だけ実行される

    useEffect(() => {
        if (prevModal.current !== null && currentModal === null) {
            // モーダルが閉じられた瞬間
            const fetchCompanies = async () => {
                setCompaniesData(await getCompanies());
            };
            fetchCompanies();
        }
        prevModal.current = currentModal;
    }, [currentModal]);

    // ここにまとめる
    const onEdit = async () => {
        //apiをぶったたく！！
        const api_url = "http://localhost/nakabayashi_system_training/cms_framework/customer-management-system-back/public/api/customers/edit";
        try {
            const send_data = new dtoCustomersEdit();
            send_data.cust_id = cust_id;
            send_data.cust_name = name;
            send_data.cust_name_kana = nameKana;
            send_data.mail_address = mailAddress;
            send_data.phone_number = phoneNumber;
            send_data.sex = sex;
            send_data.born_date = bornDate;
            send_data.company_id = company;

            const response_api = await fetch(api_url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(send_data),
                credentials: 'include',
            });
            const result = await response_api.json();
            console.log(result);
            if(result.success == true) 
            {
                alert("顧客情報の編集に成功しました。");
            }
        } catch(error) {
            console.error("編集失敗", error);
        }
    };

    const handleCompanyListOpen = () => {
        console.log('モーダル開く');
        openCompanyList();
    };

    const handleBackToList = () => {
        navigate('/cust_list');
    };

    return (
        <div className="main-wrapper">
            <div className="main-header">
                <h1 className="main-title">顧客情報編集</h1>
            </div>

            <div className="main-content">
                <h1 className="content-title">顧客情報編集</h1>

                <div className="edit-input">
                <table className="edit-input-table">
                    <tbody>
                        <tr className="edit-input-name">
                            <th width="100px">顧客名</th>
                            <td className="edit-input-form" id="edit-input-name" width="100px">
                                <input type="text" placeholder="佐藤　次郎" value={name} onChange={(e) => setName(e.target.value)} />
                            </td>
                        </tr>
                        <tr className="edit-input-name-kana">
                            <th width="100px">顧客名カナ</th>
                            <td className="edit-input-form" id="edit-input-name-kana" width="100px">
                                <input type="text" placeholder="サトウ　ジロウ" value={nameKana} onChange={(e) => setNameKana(e.target.value)} />
                            </td>
                        </tr>
                        <tr className="edit-input-mail-address">
                            <th width="100px">メールアドレス</th>
                            <td className="edit-input-form" id="edit-input-mail-address" width="100px">
                                <input type="text" placeholder="jirou@gmail.com" value={mailAddress} onChange={(e) => setMailAddress(e.target.value)} />
                            </td>
                        </tr>
                        <tr className="edit-input-phone-number">
                            <th width="100px">電話番号</th>
                            <td className="edit-input-form" id="edit-input-phone-number" width="100px">
                                <input type="text" placeholder="090-0000-0000" value={phoneNumber} onChange={(e) => setPhoneNumber(e.target.value)} />
                            </td>
                        </tr>
                        <tr className="edit-input-sex">
                            <th width="100px">性別</th>
                            <td className="edit-input-form" id="edit-input-sex" width="100px">
                                <select value={sex} onChange={(e) => setSex(e.target.value)}>
                                <option value="男性">男性</option>
                                <option value="女性">女性</option>
                                <option value="その他">その他</option>
                                </select>
                            </td>
                        </tr>
                        <tr className="edit-input-born-date">
                            <th width="100px">生年月日</th>
                            <td className="edit-input-form" id="edit-input-born-date" width="100px">
                                <input type="date" value={bornDate} onChange={(e) => setBornDate(e.target.value)} />
                            </td>
                        </tr>
                        <tr className="edit-input-company">
                            <th width="100px">所属会社</th>
                            <td className="edit-input-form" id="edit-input-company" width="100px">
                                <select id="search_company" value={company} onChange={(e) => setCompany(e.target.value)}>
                                <option value="">会社を選択</option>
                                {companiesData.map((companyItem) => (
                                    <option key={companyItem.company_id} value={companyItem.company_id}>
                                        {companyItem.company_name}
                                    </option>
                                ))}
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div className="content-company">
                    <button className="company-button button" type="button" onClick={handleCompanyListOpen}>会社一覧</button>
                </div>
                </div>

                <div className="content-edit">
                    <button className="edit-button button" id="edit-button-action" type="button" onClick={onEdit}>編集</button>
                </div>

                <div className="content-return">
                    <button className="return-button button" id="return-button" type="button" onClick={handleBackToList}>一覧へ</button>
                </div>
                <CompaniesListModal
                isOpen={currentModal === "list"}
                onClose={closeModal}
                onEntry={openCompanyEntry}
                onEdit={openCompanyEdit}
                />
                <CompaniesEntryModal
                isOpen={currentModal === "entry"}
                onClose={closeModal}
                onBack={openCompanyList}
                />
                <CompaniesEditModal
                isOpen={currentModal === "edit"}
                companyId={editCompanyId}
                onClose={closeModal}
                onBack={openCompanyList}
                />
            </div>
        </div>
    );
}

export default CustomerEditPage;
