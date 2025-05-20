export default function CompaniesEntryModal({ isOpen, onClose, onBack }) {
  if (!isOpen) return null;

  const onEntry = async () => {

  }

  return (
    <div className="modal-company-entry modal" id="modal-company-entry">
      <div className="modal-main-wrappar">
        <div className="modal-main-header">
          <span className="modal-close-button" onClick={onClose}>&times;</span>
          <div className="modal-main-title">
            <h2>所属会社登録</h2>
          </div>
        </div>

        <div className="modal-main-content">
          <div className="modal-content-entry-input">
            <table className="modal-entry-input-table" bgcolor="#a9a9a9">
              <tbody>
                <tr className="modal-entry-input-name" style={{ height: "24px" }} align="center">
                  <th width="100px" bgcolor="#D3D3D3">会社名</th>
                  <td className="modal-entry-input-form-name" width="200px" bgcolor="#FFFFFF">
                    <input type="text" id="modal-entry-input-name" placeholder="株式会社○○" />
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div className="modal-content-entry">
            <button className="modal-entry-button entry-button button" id="modal-entry-button" onClick={onEntry}>
              登録
            </button>
          </div>

          <div className="modal-content-return">
            <button className="modal-return-button button" onClick={onBack}>
              戻る
            </button>
          </div>
        </div>
      </div>
    </div>
  );
}
