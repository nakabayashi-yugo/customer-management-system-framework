import useModalController from "../modal_controller";

export default function CompaniesListModal({ isOpen, onClose, onEntry, onEdit }) {
  if (!isOpen) return null;

  return (
    <div className="modal-companies-list modal" id="modal-company-list">
      <div className="modal-main-wrappar">
        <div className="modal-main-header">
          <span
            className="modal-close-button"
            onClick={onClose}
          >
            &times;
          </span>
          <div className="modal-main-title">
            <h2>所属会社一覧</h2>
          </div>
        </div>

        <div className="modal-main-content">
          <div className="modal-content-entry">
            <button
              className="modal-entry-button entry-button button"
              onClick={onEntry}
            >
              会社登録
            </button>
          </div>

          <div className="modal-content-list">
            <div className="modal-list-companies">
              <table
                className="modal-list-companies-table"
                id="list-customers-table"
                bgcolor="#a9a9a9"
              >
                <thead>
                  <tr className="modal-list-companies-table-header" bgcolor="#D3D3D3">
                    <th width="50px">会社ID</th>
                    <th width="300px">会社名</th>
                    <th width="50px">編集</th>
                    <th width="50px">削除</th>
                  </tr>
                </thead>
                <tbody
                  className="modal-list-companies-table-body"
                  id="modal-list-companies-table-body"
                  bgcolor="white"
                >
                  {/* ここにJSでデータ表示 */}
                </tbody>
              </table>
            </div>
          </div>

          <div className="modal-content-return">
            <button
              className="modal-return-button button"
              onClick={onClose}
            >
              戻る
            </button>
          </div>
        </div>
      </div>
    </div>
  );
}
